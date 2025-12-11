<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['buyer.user', 'store'])
            ->latest()
            ->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['details.product', 'buyer.user', 'store']);

        return view('admin.transactions.show', compact('transaction'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $data = $request->validate([
            'payment_status' => ['required', 'in:pending,waiting_confirmation,paid,failed'],
        ]);

        $transaction->update([
            'payment_status' => $data['payment_status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status pembayaran diubah menjadi: ' . $transaction->status_label);
    }
}
