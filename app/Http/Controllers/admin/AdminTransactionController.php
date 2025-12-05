<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class AdminTransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('buyer','store')->paginate(20);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.product');
        return view('admin.transactions.show', compact('transaction'));
    }
}
