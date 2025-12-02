<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // List order masuk untuk seller
    public function index()
    {
        $store = Auth::user()->store;
        // ambil transaksi untuk store ini
        $orders = Transaction::where('store_id', $store->id)
                              ->orderBy('created_at', 'desc')
                              ->paginate(15);

        return view('seller.orders.index', compact('orders'));
    }

    // Detail satu order / transaksi
    public function show($id)
    {
        $store = Auth::user()->store;
        $order = Transaction::where('store_id', $store->id)->with('details.product', 'buyer', 'transactionDetails')->findOrFail($id);

        return view('seller.orders.show', compact('order'));
    }

    // Update status / resi pengiriman, tracking number, dsb
    public function update(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
            'shipping_status' => 'nullable|string|max:50',
            // bisa ditambah field lain seperti shipping_type, cost, dsb
        ]);

        $store = Auth::user()->store;
        $order = Transaction::where('store_id', $store->id)->findOrFail($id);

        $order->tracking_number = $request->tracking_number;
        if ($request->shipping_status) {
            $order->shipping_status = $request->shipping_status;
        }
        $order->save();

        return redirect()->route('seller.orders.show', $id)
                         ->with('success', 'Order diperbarui.');
    }
}
