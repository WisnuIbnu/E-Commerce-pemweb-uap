<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    public function index()
    {
        $store = getSellerStore();
        
        // Calculate total revenue from completed orders
        $totalRevenue = Transaction::where('status', 'completed')
            ->whereHas('details', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })->sum('total_amount');
        
        // Calculate total withdrawn
        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');
        
        $currentBalance = $totalRevenue - $totalWithdrawn;
        
        // Recent transactions
        $transactions = Transaction::where('status', 'completed')
            ->whereHas('details', function($q) use ($store) {
                $q->whereHas('product', function($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->latest()
            ->take(10)
            ->get();
        
        return view('seller.balance.index', compact(
            'store', 
            'currentBalance', 
            'totalRevenue', 
            'totalWithdrawn',
            'transactions'
        ));
    }
}
