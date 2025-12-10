<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class SellerBalanceController extends Controller
{
    public function index()
    {
        // Store yang sedang login
        $store = auth()->user()->store;

        // Total pendapatan dari transaksi paid
        $totalRevenue = Transaction::where('payment_status', 'paid')
            ->whereHas('transactionDetails', function ($q) use ($store) {
                $q->whereHas('product', function ($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->sum('grand_total');

        // Total withdraw yang approved
        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');

        // Saldo saat ini
        $currentBalance = $totalRevenue - $totalWithdrawn;

        // Transaksi terbaru
        $transactions = Transaction::where('payment_status', 'paid')
            ->whereHas('transactionDetails', function ($q) use ($store) {
                $q->whereHas('product', function ($q2) use ($store) {
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
