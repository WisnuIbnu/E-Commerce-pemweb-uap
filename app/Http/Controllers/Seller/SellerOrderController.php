<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerOrderController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())
                      ->where('is_verified', 1)
                      ->first();

        $orders = Transaction::where('store_id', $store->id)
            ->with(['buyer'])
            ->latest()
            ->get();

        return view('seller.orders.index', compact('orders', 'store'));
    }

    public function show($id)
    {
        // FIX: tidak pakai helper
        $store = Store::where('user_id', auth()->id())
                      ->where('is_verified', 1)
                      ->first();

        // FIX: relasi yg benar = transactionDetails
        $order = Transaction::where('store_id', $store->id)
            ->whereHas('transactionDetails', function ($q) use ($store) {
                $q->whereHas('product', function ($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->with(['buyer', 'transactionDetails.product'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('order', 'store'));
    }
}
