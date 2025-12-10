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
            ->firstOrFail();

        $orders = Transaction::where('store_id', $store->id)
            ->with(['buyer'])
            ->latest()
            ->paginate(10);

        return view('seller.orders.index', compact('orders', 'store'));
    }

    public function show($id)
    {
        $store = Store::where('user_id', auth()->id())
            ->where('is_verified', 1)
            ->firstOrFail();

        $order = Transaction::where('store_id', $store->id)
            ->with(['buyer', 'details.product'])
            ->findOrFail($id);

        return view('seller.orders.show', compact('order', 'store'));
    }
}
