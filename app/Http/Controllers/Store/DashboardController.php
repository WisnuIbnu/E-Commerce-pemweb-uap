<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        $stats = [
            'total_products' => $store->products()->count(),
            'pending_orders' => Transaction::where('store_id', $store->id)
                ->whereIn('payment_status', ['pending', 'processing'])
                ->count(),
            'total_revenue' => Transaction::where('store_id', $store->id)
                ->where('payment_status', 'delivered')
                ->sum('grand_total'),
            'balance' => $store->balance->balance ?? 0,
        ];

        $recentOrders = Transaction::where('store_id', $store->id)
            ->with(['buyer', 'details.product'])
            ->latest()
            ->limit(5)
            ->get();

        return view('store.dashboard', compact('stats', 'recentOrders'));
    }
}
