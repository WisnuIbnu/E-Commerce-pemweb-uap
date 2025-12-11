<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index($code)
    {
        $transaction = Transaction::with('transactionDetails.product')
            ->where('code', $code)
            ->whereHas('buyer', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->firstOrFail();

        return view('front.payment', compact('transaction'));
    }

    public function update($code)
    {
        $transaction = Transaction::where('code', $code)->firstOrFail();
        
        // Update status jadi Paid
        $transaction->update(['payment_status' => 'paid']);

        return redirect()->route('transactions.index')->with('success', 'Pembayaran Berhasil! Pesanan sedang diproses.');
    }
}