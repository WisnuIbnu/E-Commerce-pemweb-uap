<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_stores' => Store::where('is_verified', true)->count(),
            'pending_stores' => Store::where('is_verified', false)->count(),
            'total_products' => Product::count(),
            'total_transactions' => Transaction::count(),
            'total_revenue' => Transaction::where('payment_status', 'delivered')->sum('grand_total'),
        ];

        $recentUsers = User::latest()->limit(5)->get();
        $recentStores = Store::with('user')->latest()->limit(5)->get();
        $recentTransactions = Transaction::with(['buyer', 'store'])->latest()->limit(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentStores', 'recentTransactions'));
    }

    public function transactions()
    {
        $transactions = Transaction::with(['buyer', 'store', 'details.product'])
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}
