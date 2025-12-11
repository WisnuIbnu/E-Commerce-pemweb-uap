<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Get overall statistics
        $stats = [
            'total_users'      => User::count(),
            'total_stores'     => Store::count(),
            'pending_stores'   => Store::where('is_verified', false)->count(),
            'total_products'   => Product::count(),
            'total_orders'     => Transaction::count(),

            // FIX: sesuaikan dengan kolom real
            'total_revenue'    => Transaction::where('payment_status', 'paid')
                                            ->sum('grand_total'),
        ];

        // Store statistics by status
        $storeStats = [
            'pending'  => Store::where('is_verified', false)->count(),
            'approved' => Store::where('is_verified', true)->count(),
            'rejected' => 0,
        ];

        // Get pending stores (limit 5 for table)
        $pendingStores = Store::with('user')
            ->where('is_verified', false)
            ->latest()
            ->take(5)
            ->get();

        // Get recent users (limit 10)
        $recentUsers = User::latest()
            ->take(10)
            ->get();

        // Get top stores by product count
        $topStores = Store::withCount('products')
            ->where('is_verified', true)
            ->orderBy('products_count', 'desc')
            ->take(5)
            ->get();

        // Monthly revenue for last 6 months
        $monthlyRevenue = Transaction::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(grand_total) as revenue')
            )
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        // If empty → dummy data
        if ($monthlyRevenue->isEmpty()) {
            $monthlyRevenue = collect([
                ['month' => now()->subMonths(5)->format('Y-m'), 'revenue' => 0],
                ['month' => now()->subMonths(4)->format('Y-m'), 'revenue' => 0],
                ['month' => now()->subMonths(3)->format('Y-m'), 'revenue' => 0],
                ['month' => now()->subMonths(2)->format('Y-m'), 'revenue' => 0],
                ['month' => now()->subMonths(1)->format('Y-m'), 'revenue' => 0],
                ['month' => now()->format('Y-m'), 'revenue' => 0],
            ]);
        }

        return view('admin.dashboard', compact(
            'stats',
            'storeStats',
            'pendingStores',
            'recentUsers',
            'topStores',
            'monthlyRevenue'
        ));
    }
}
