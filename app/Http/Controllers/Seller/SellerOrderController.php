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

        // Field yang dikirim dari form: "status" & "tracking_number"
        $validated = $request->validate([
            'status'          => ['required', 'in:pending,processing,shipped,completed,cancelled'],
            'tracking_number' => ['nullable', 'string', 'max:255'],
        ]);

        // ⬇️ DI SINI yang penting:
        // Form pakai "status", tapi di DB kolomnya "payment_status"
        $order->payment_status  = $validated['status'];
        $order->tracking_number = $validated['tracking_number'] ?? null;

        $order->save();

        return redirect()
            ->route('seller.orders.show', $order)
            ->with('success', 'Pesanan berhasil diperbarui.');
    }
}
