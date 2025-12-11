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
    public function index(Request $request)
    {
        $user    = Auth::user();
        $storeId = $request->query('store_id'); // dari tombol "Checkout toko ini"

        $cartItems = CartItem::with('product.store')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        // cek berapa toko di keranjang
        $storesInCart = $cartItems->pluck('product.store')->filter()->unique('id');

        // kalau keranjang punya >1 toko dan user tidak kirim store_id → suruh pilih dulu
        if (!$storeId) {
            if ($storesInCart->count() > 1) {
                return redirect()
                    ->route('cart.index')
                    ->with('error', 'Keranjang berisi produk dari beberapa toko. Silakan pilih dulu toko mana yang ingin di-checkout.');
            }

            // kalau cuma 1 toko, pilih otomatis
            $storeId = optional($storesInCart->first())->id;
        }

        // filter item yang benar-benar dari toko yang dipilih
        $checkoutItems = $cartItems->filter(function ($item) use ($storeId) {
            return $item->product && $item->product->store_id == $storeId;
        });

        if ($checkoutItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Tidak ada produk dari toko yang dipilih di keranjang kamu.');
        }

        $buyer = $user->buyer;

        $total = $checkoutItems->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        return view('checkout.index', [
            'cartItems'     => $checkoutItems,
            'buyer'         => $buyer,
            'total'         => $total,
            'storeId'       => $storeId,
            'storesInCart'  => $storesInCart,
        ]);
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
            'payment_method' => 'nullable|string',
            'store_id'       => 'required|integer',
        ]);

        $user    = Auth::user();
        $storeId = (int) $request->input('store_id');

        // Ambil buyer, kalau belum ada → buat otomatis
        $buyer = $user->buyer;
        if (!$buyer) {
            $buyer = Buyer::create([
                'user_id'         => $user->id,
                'profile_picture' => null,
                'phone_number'    => null,
            ]);
        }

        $allCartItems = CartItem::with('product.store')
            ->where('user_id', $user->id)
            ->get();

        if ($allCartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Keranjang masih kosong.');
        }

        // item yang ikut checkout (hanya dari store_id yang dipilih)
        $checkoutItems = $allCartItems->filter(function ($item) use ($storeId) {
            return $item->product && $item->product->store_id == $storeId;
        });

        if ($checkoutItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Tidak ada produk dari toko yang dipilih di keranjang kamu.');
        }

        // hitung subtotal
        $subtotal = $checkoutItems->sum(function ($item) {
            return $item->product->price * $item->qty;
        });

        // ongkir dummy berdasarkan jenis pengiriman
        $shippingCost = match ($request->shipping_type) {
            'REG'   => 20000,
            'EXP'   => 35000,
            'SDS'   => 50000,
            default => 20000,
        };

        $tax        = 0;
        $grandTotal = $subtotal + $shippingCost + $tax;

        // buat transaksi
        $transaction = Transaction::create([
            'code'            => 'TRX-' . Str::upper(Str::random(8)),
            'buyer_id'        => $buyer->id,
            'store_id'        => $storeId,
            'address'         => $request->address,
            'address_id'      => null,
            'city'            => $request->city,
            'postal_code'     => $request->postal_code,
            'shipping'        => $request->shipping,
            'shipping_type'   => $request->shipping_type,
            'shipping_cost'   => $shippingCost,
            'tracking_number' => null,
            'tax'             => $tax,
            'grand_total'     => $grandTotal,
            'payment_status'  => Transaction::STATUS_PENDING,
            'payment_method'  => $request->payment_method ?? null,
        ]);

        // simpan detail transaksi + kurangi stok + hapus item yang ikut checkout
        foreach ($checkoutItems as $cartItem) {
            $price = $cartItem->product->price;

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id'     => $cartItem->product_id,
                'qty'            => $cartItem->qty,
                'price'          => $price,
                'subtotal'       => $price * $cartItem->qty,
            ]);

            $cartItem->product->decrement('stock', $cartItem->qty);
            $cartItem->delete(); // hanya item dari toko ini yang dihapus
        }

        // item dari toko lain tetap ada di cart

        return redirect()
            ->route('transactions.show', $transaction->id)
            ->with('success', 'Pesanan berhasil dibuat, silakan lakukan pembayaran. Produk dari toko lain tetap ada di keranjang kamu.');
    }
}
