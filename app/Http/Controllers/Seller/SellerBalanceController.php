<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SellerBalanceController extends Controller
{
  
    public function index()
    {
        $store = Auth::user()->store;

        if (! $store) {
            abort(404, 'Toko tidak ditemukan');
        }

        // Transaksi yang sudah dibayar untuk toko ini
        $transactions = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->orderByDesc('created_at')
            ->get();

        // Saldo = jumlah grand_total semua transaksi paid
        $balance = $transactions->sum('grand_total');

        // Untuk ringkasan
        $todayIncome = $transactions
            ->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])
            ->sum('grand_total');

        $totalOrdersPaid = $transactions->count();

        return view('seller.balance.index', compact(
            'store',
            'transactions',
            'balance',
            'todayIncome',
            'totalOrdersPaid'
        ));
    }
}
