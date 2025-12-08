<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // HALAMAN CHECKOUT
    public function index()
    {
        $user = Auth::user();

        $cartItems = CartItem::with('product.store')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('success', 'Keranjang masih kosong.');
        }

        $buyer = $user->buyer; // bisa null kalau belum punya row di buyers

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        return view('checkout.index', compact('cartItems', 'buyer', 'total'));
    }

    // PROSES CHECKOUT
    public function store(Request $request)
    {
        $request->validate([
            'address'        => 'required|string',
            'city'           => 'required|string',
            'postal_code'    => 'required|string',
            'shipping'       => 'required|string',
            'shipping_type'  => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $user = Auth::user();

        // Ambil buyer, kalau belum ada → buat otomatis
        $buyer = $user->buyer;
        if (!$buyer) {
            $buyer = Buyer::create([
                'user_id'         => $user->id,
                'profile_picture' => null,
                'phone_number'    => null,
            ]);
        }

        $cartItems = CartItem::with('product.store')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('success', 'Keranjang masih kosong.');
        }

        // Hitung ongkir berdasarkan jenis pengiriman (kisaran)
        $shippingType = $request->shipping_type;
        $shippingCost = match ($shippingType) {
            'REG'      => 20000,
            'EXPRESS'  => 35000,
            'SDS'      => 50000,
            default    => 20000,
        };

        // Group cart berdasarkan toko
        $groupedByStore = $cartItems->groupBy(function ($item) {
            return $item->product->store_id;
        });

        $createdTransactions = [];

        foreach ($groupedByStore as $storeId => $items) {
            $subtotal = $items->sum(function ($item) {
                return $item->product->price * $item->qty;
            });

            $tax        = 0;
            $grandTotal = $subtotal + $shippingCost + $tax;

            $transaction = Transaction::create([
                'code'            => 'TRX-' . Str::upper(Str::random(8)),
                'buyer_id'        => $buyer->id,  // ID dari tabel buyers
                'store_id'        => $storeId,
                'address'         => $request->address,
                'address_id'      => null,
                'city'            => $request->city,
                'postal_code'     => $request->postal_code,
                'shipping'        => $request->shipping,
                'shipping_type'   => $shippingType,
                'shipping_cost'   => $shippingCost,
                'tracking_number' => null,
                'tax'             => $tax,
                'grand_total'     => $grandTotal,
                'payment_status'  => 'pending',
                'payment_method'  => $request->payment_method,
            ]);

            foreach ($items as $cartItem) {
                $price = $cartItem->product->price;  // ambil harga produk

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $cartItem->product_id,
                    'qty'            => $cartItem->qty,
                    'price'          => $price,                               // simpan harga satuan
                    'subtotal'       => $price * $cartItem->qty,
                ]);

                // kurangi stok
                $cartItem->product->decrement('stock', $cartItem->qty);
            }

            $createdTransactions[] = $transaction;
        }

        // hapus cart setelah checkout
        CartItem::where('user_id', $user->id)->delete();

        if (!empty($createdTransactions)) {
            $firstTransaction = $createdTransactions[0];

            return redirect()
                ->route('transactions.show', $firstTransaction->id)
                ->with('success', 'Pesanan berhasil dibuat, silakan lakukan pembayaran.');
        }

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Pesanan berhasil dibuat, silakan cek riwayat transaksi.');
    }
}
