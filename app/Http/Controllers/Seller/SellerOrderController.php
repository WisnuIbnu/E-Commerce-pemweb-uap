<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction as Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{

    /**
     * Helper: ambil store milik seller yang login.
     */
    protected function sellerStore()
    {
        return Auth::user()->store;
    }

    /**
     * List pesanan untuk toko ini.
     */
    public function index()
    {
        $store = $this->sellerStore();

        $orders = Order::with(['buyer', 'details'])
            ->where('store_id', $store->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('seller.orders.index', compact('store', 'orders'));
    }

    /**
     * Detail satu pesanan.
     */
    public function show(Order $order)
    {
        $store = $this->sellerStore();

        // pastikan pesanan ini memang milik toko yang login
        if ($order->store_id !== $store->id) {
            abort(403);
        }

        $order->load(['buyer', 'details']); 

        return view('seller.orders.show', compact('store', 'order'));
    }

    /**
     * Update status pesanan & nomor resi.
     */
    public function update(Request $request, Order $order)
    {
        $store = $this->sellerStore();

        if ($order->store_id !== $store->id) {
            abort(403);
        }

        $validated = $request->validate([
            'shipping'         => ['nullable', 'string', 'max:255'],
            'shipping_type'    => ['nullable', 'string', 'max:50'],
            'tracking_number'  => ['nullable', 'string', 'max:255'],
            'payment_status'   => ['required', 'in:pending,paid,shipped,completed,cancelled'],
            // list status silakan kamu sesuaikan sendiri
        ]);

        $order->fill($validated);
        $order->save();

        return redirect()
            ->route('seller.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }
}
