<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $store = auth()->user()->store;

        $query = Transaction::where('store_id', $store->id)
            ->with(['buyer', 'details.product']);

        if ($request->has('status') && $request->status != '') {
            $query->where('payment_status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('store.order.index', compact('orders'));
    }

    public function show($id)
    {
        $store = auth()->user()->store;

        $order = Transaction::where('store_id', $store->id)
            ->with(['buyer', 'details.product.images'])
            ->findOrFail($id);

        return view('store.order.show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $store = auth()->user()->store;

        $order = Transaction::where('store_id', $store->id)->findOrFail($id);
        $order->update(['payment_status' => $request->status]);

        return redirect()->back()->with('success', 'Order status updated successfully');
    }

    public function updateTracking(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:100',
        ]);

        $store = auth()->user()->store;

        $order = Transaction::where('store_id', $store->id)->findOrFail($id);
        $order->update([
            'tracking_number' => $request->tracking_number,
            'payment_status' => 'shipped',
        ]);

        return redirect()->back()->with('success', 'Tracking number added successfully');
    }
}