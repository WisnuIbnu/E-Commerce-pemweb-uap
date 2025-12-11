<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:customer']);
    }

    public function index()
    {
        // gunakan buyer_id, dan paginate biar $transactions->links() bisa dipakai
        $transactions = Transaction::where('buyer_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('customer.transactions.index', compact('transactions'));
    }

    public function detail($id)
    {
        $transaction = Transaction::where('id', $id)
            ->where('buyer_id', auth()->id())
            ->firstOrFail();

        return view('customer.transactions.detail', compact('transaction'));
    }
}
