<?php
// app/Http/Controllers/Seller/BalanceController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Calculate earnings
        $totalEarnings = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })
        ->where('status', 'completed')
        ->sum('total');

        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'completed')
            ->sum('amount');

        $pendingWithdrawal = $store->withdrawals()
            ->where('status', 'pending')
            ->sum('amount');

        // Recent transactions
        $recentTransactions = Transaction::with(['buyer'])
            ->whereHas('items', function($query) use ($store) {
                $query->whereHas('product', function($q) use ($store) {
                    $q->where('store_id', $store->id);
                });
            })
            ->where('status', 'completed')
            ->latest()
            ->take(10)
            ->get();

        // Monthly earnings chart data
        $monthlyEarnings = Transaction::whereHas('items', function($query) use ($store) {
            $query->whereHas('product', function($q) use ($store) {
                $q->where('store_id', $store->id);
            });
        })
        ->where('status', 'completed')
        ->where('created_at', '>=', now()->subMonths(6))
        ->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(total) as earnings')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        return view('seller.balance.index', compact(
            'store',
            'totalEarnings',
            'totalWithdrawn',
            'pendingWithdrawal',
            'recentTransactions',
            'monthlyEarnings'
        ));
    }
}

