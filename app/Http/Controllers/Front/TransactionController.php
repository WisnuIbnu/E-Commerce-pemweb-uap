<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Menampilkan daftar riwayat transaksi
    public function index()
    {
        // Ambil transaksi dimana buyer terkait dengan user yang login
        $transactions = Transaction::with(['store', 'transactionDetails.product'])
            ->whereHas('buyer', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->latest()
            ->get();

        return view('front.transactions.index', compact('transactions'));
    }

    // Menampilkan detail satu transaksi tertentu
    public function show($code)
    {
        $transaction = Transaction::with(['store', 'transactionDetails.product', 'buyer'])
            ->where('code', $code)
            ->whereHas('buyer', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('front.transactions.details', compact('transaction'));
    }
}