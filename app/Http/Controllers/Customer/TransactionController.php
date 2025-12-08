<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','role:customer']);
    }

    // Daftar transaksi customer
    public function index()
    {
        $transactions = Transaction::with('details.product.store')
            ->where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('transactions.index', compact('transactions'));
    }

    // Detail transaksi
    public function detail($id)
    {
        $transaction = Transaction::with('details.product.store')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('transactions.detail', compact('transaction'));
    }
}
