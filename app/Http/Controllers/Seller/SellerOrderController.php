<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $store = getSellerStore();
        
        $orders = Transaction::whereHas('details', function($q) use ($store) {
            $q->whereHas('product', function($q2) use ($store) {
                $q2->where('store_id', $store->id);
            });
        })->with(['user', 'details.product'])
        ->latest()
        ->paginate(20);
        
        return view('seller.orders.index', compact('orders', 'store'));
    }

    public function show($id)
    {
        $store = getSellerStore();
        
        $order = Transaction::whereHas('details', function($q) use ($store) {
            $q->whereHas('product', function($q2) use ($store) {
                $q2->where('store_id', $store->id);
            });
        })->with(['user', 'details.product'])
        ->findOrFail($id);
        
        return view('seller.orders.show', compact('order', 'store'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:processing,shipped,delivered',
            'tracking_number' => 'nullable|string',
        ]);

        $store = getSellerStore();
        
        $order = Transaction::whereHas('details', function($q) use ($store) {
            $q->whereHas('product', function($q2) use ($store) {
                $q2->where('store_id', $store->id);
            });
        })->findOrFail($id);

        $order->update([
            'status' => $request->status,
            'tracking_number' => $request->tracking_number,
        ]);

        return redirect()->route('seller.orders.show', $id)
            ->with('success', 'Status pesanan berhasil diperbarui.');
    }
}