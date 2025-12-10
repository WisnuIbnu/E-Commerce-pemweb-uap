<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BuyerCheckoutController extends Controller
{
    const CART_STATUS = 'cart';

    public function index(Request $request)
    {
        $user = auth()->user();

        // Handle "Beli Sekarang" - dari product detail page
        if ($request->has('product_id') && $request->has('qty')) {
            $product = Product::findOrFail($request->product_id);
            $qty = intval($request->qty);

            // Validasi
            if ($qty < 1 || $qty > $product->stock) {
                return redirect()
                    ->route('buyer.products.show', $product->id)
                    ->with('error', 'Jumlah produk tidak valid');
            }

            // Buat temporary item untuk checkout
            $items = collect([
                (object)[
                    'id' => 0,
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'total_price' => $product->price * $qty,
                    'product' => $product,
                ]
            ]);

            session(['temp_checkout' => [
                'product_id' => $product->id,
                'qty' => $qty
            ]]);
        } else {
            // Ambil dari keranjang (status = 'cart')
            $items = $user->orders()
                ->where('status', self::CART_STATUS)
                ->with('product.store')
                ->get();

            if ($items->isEmpty()) {
                return redirect()
                    ->route('buyer.cart.index')
                    ->with('error', 'Keranjang Anda masih kosong.');
            }
        }

        // Hitung subtotal
        $subtotal = $items->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        // Ambil alamat jika ada (sesuaikan dengan model Buyer)
        $addresses = collect([]);

        return view('buyer.checkout.index', compact('items', 'subtotal', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
        $user = $request->user();
        $buyer = Buyer::where('user_id', $user->id)->firstOrFail();

        // Validasi data
        $validated = $request->validate([
            'shipping_address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
            'shipping_method' => 'required|in:regular,express,same-day',
            'payment_method' => 'required|in:transfer,ewallet,cod',
        ]);

        // Tentukan items
        $cartItems = null;
        if (session('temp_checkout')) {
            // Dari "Beli Sekarang"
            $tempData = session('temp_checkout');
            $product = Product::findOrFail($tempData['product_id']);
            $qty = $tempData['qty'];

            $cartItems = collect([
                (object)[
                    'id' => 0,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'product' => $product,
                ]
            ]);
        } else {
            // Dari keranjang
            $cartItems = $user->orders()
                ->where('status', self::CART_STATUS)
                ->with('product.store')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('buyer.cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        // Kelompokkan berdasarkan store
        $transactionsByStore = $cartItems->groupBy(function($item) {
            return $item->product->store_id;
        });

        // Biaya pengiriman
        $shippingCosts = [
            'regular' => 15000,
            'express' => 25000,
            'same-day' => 35000,
        ];
        $baseShippingCost = $shippingCosts[$validated['shipping_method']] ?? 15000;
        $taxRate = 0.0;

        DB::transaction(function () use (
            $user, $buyer, $validated, $transactionsByStore, 
            $baseShippingCost, $taxRate, $cartItems
        ) {
            foreach ($transactionsByStore as $storeId => $items) {
                $subtotal = $items->sum(function($item) {
                    return $item->product->price * $item->quantity;
                });

                $shippingCost = $baseShippingCost;
                $tax = $subtotal * $taxRate;
                $grandTotal = $subtotal + $shippingCost + $tax;

                // Buat transaction header
                $transaction = Transaction::create([
                    'code' => 'TRX-' . Str::upper(Str::random(10)),
                    'buyer_id' => $buyer->id,
                    'store_id' => $storeId,
                    'address' => $validated['shipping_address'],
                    'city' => $validated['city'],
                    'postal_code' => $validated['postal_code'],
                    'shipping' => $validated['shipping_method'],
                    'shipping_type' => $validated['shipping_method'],
                    'shipping_cost' => $shippingCost,
                    'tax' => $tax,
                    'grand_total' => $grandTotal,
                    'payment_status' => 'unpaid',
                ]);

                // Buat transaction details
                foreach ($items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item->product_id,
                        'qty' => $item->quantity,
                        'subtotal' => $item->product->price * $item->quantity,
                    ]);

                    // Update stock
                    Product::where('id', $item->product_id)
                        ->decrement('stock', $item->quantity);
                }

                // Hapus dari cart (jika bukan dari "Beli Sekarang")
                if (!session('temp_checkout')) {
                    Order::whereIn('id', $items->pluck('id'))
                        ->update(['status' => 'processed']);
                }
            }

            // Clear session
            session()->forget('temp_checkout');
        });

        return redirect()
            ->route('buyer.orders.index')
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}