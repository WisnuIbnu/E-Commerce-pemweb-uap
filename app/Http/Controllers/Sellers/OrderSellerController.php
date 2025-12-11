<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderSellerController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;

        $orders = Transaction::where('store_id', $store->id)
            ->with('customer')
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
            'tracking_number' => 'nullable|string'
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->tracking_number = $request->tracking_number;
        $order->save();

        return back()->with('success', 'Order status updated!');
    }
}