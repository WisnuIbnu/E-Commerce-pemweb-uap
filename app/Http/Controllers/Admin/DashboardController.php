<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        // Statistics
        $totalUsers = User::count();
        $totalStores = Store::count();
        $verifiedStores = Store::where('is_verified', true)->count();
        $pendingStores = Store::where('is_verified', false)->count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalRevenue = Transaction::where('payment_status', 'paid')->sum('grand_total');
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();

        // Recent activities
        $recentStores = Store::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with(['buyer.user', 'store'])
            ->latest()
            ->take(5)
            ->get();

        $recentWithdrawals = Withdrawal::with('storeBalance.store')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores',
            'verifiedStores',
            'pendingStores',
            'totalProducts',
            'totalTransactions',
            'totalRevenue',
            'pendingWithdrawals',
            'recentStores',
            'recentTransactions',
            'recentWithdrawals'
        ));
    }
}