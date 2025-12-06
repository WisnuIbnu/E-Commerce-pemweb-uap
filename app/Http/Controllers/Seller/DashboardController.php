<?php

// app/Http/Controllers/Seller/DashboardController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        
        // Statistics
        $totalProducts = $store->products()->count();
        $totalOrders = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->count();
        
        $totalRevenue = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->where('status', 'completed')->sum('total');
        
        $pendingOrders = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })->where('status', 'pending')->count();

        // Recent orders
        $recentOrders = Transaction::with(['buyer', 'items.product'])
            ->whereHas('items', function($query) use ($store) {
                $query->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                });
            })
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = $store->products()
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('seller.dashboard', compact(
            'store',
            'totalProducts',
            'totalOrders',
            'totalRevenue',
            'pendingOrders',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}
