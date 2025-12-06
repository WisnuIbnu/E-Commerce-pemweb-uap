<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Tampilkan list semua transaksi milik buyer yang sedang login.
     */
    public function index()
    {
        $buyer = Auth::user()->buyer; // dijamin ada oleh middleware

        $transactions = Transaction::with([
                'store',
                'transactionDetails.product',
            ])
            ->where('buyer_id', $buyer->id)  // ownership check
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('riwayat', compact('transactions'));
    }

    /**
     * Tampilkan detail satu transaksi berdasarkan code.
     */
    public function show(string $code)
    {
        $buyer = Auth::user()->buyer;

        $transaction = Transaction::with([
                'store',
                'transactionDetails.product',
            ])
            ->where('code', $code)
            ->where('buyer_id', $buyer->id) // ownership check
            ->firstOrFail();

        return view('riwayat_detail', compact('transaction'));
    }
}
