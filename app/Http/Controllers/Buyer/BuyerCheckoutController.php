<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class BuyerCheckoutController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Ambil item keranjang milik user (pastikan relasi cartItems sudah ada di model User)
        $items = $user->cartItems ?? collect();

        // Kalau keranjang kosong, jangan lanjut ke checkout
        if ($items->isEmpty()) {
            return redirect()
                ->route('buyer.cart.index')
                ->with('error', 'Keranjang Anda masih kosong.');
        }

        // Hitung subtotal (harga x qty)
        $subtotal = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Kalau kamu punya relasi alamat, bisa dipakai. Kalau belum, collect() aja.
        $addresses = $user->addresses ?? collect();

        return view('buyer.checkout.index', compact('items', 'subtotal', 'addresses'));
    }

    public function placeOrder(Request $request)
    {
        $user = $request->user();

        // 1. Validasi data dari form checkout
        $validated = $request->validate([
            'receiver_name'    => 'required|string|max:255',
            'receiver_phone'   => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'city'             => 'required|string|max:100',
            'postal_code'      => 'required|string|max:10',
            'shipping_method'  => 'required|in:regular,express,same-day',
            'payment_method'   => 'required|in:transfer,ewallet,cod',
        ]);

        // 2. Ambil item di keranjang user
        $items = $user->cartItems ?? collect();

        if ($items->isEmpty()) {
            return redirect()
                ->route('buyer.cart.index')
                ->with('error', 'Keranjang Anda kosong, tidak bisa membuat pesanan.');
        }

        // 3. Hitung subtotal & ongkir di backend
        $subtotal = $items->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        $shippingCosts = [
            'regular'  => 15000,
            'express'  => 25000,
            'same-day' => 35000,
        ];

        $shippingCost = $shippingCosts[$validated['shipping_method']] ?? 15000;
        $total        = $subtotal + $shippingCost;

        // 4. Simpan order + order items dalam transaksi
        DB::transaction(function () use ($user, $validated, $items, $subtotal, $shippingCost, $total) {

            // Buat record order
            $order = Order::create([
                'user_id'          => $user->id,
                'receiver_name'    => $validated['receiver_name'],
                'receiver_phone'   => $validated['receiver_phone'],
                'shipping_address' => $validated['shipping_address'],
                'city'             => $validated['city'],
                'postal_code'      => $validated['postal_code'],
                'shipping_method'  => $validated['shipping_method'],
                'payment_method'   => $validated['payment_method'],
                'subtotal'         => $subtotal,
                'shipping_cost'    => $shippingCost,
                'total_amount'     => $total,
                'status'           => 'pending', // sesuaikan dengan enum/status di tabel orders
            ]);

            // Buat order items
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                    'total'      => $item->product->price * $item->quantity,
                ]);
            }

            // Hapus semua item di keranjang setelah order dibuat
            Cart::where('user_id', $user->id)->delete();
        });

        // 5. Redirect ke halaman daftar pesanan
        return redirect()
            ->route('buyer.orders.index')
            ->with('success', 'Pesanan Anda berhasil dibuat. Silakan cek halaman pesanan.');
    }
}
