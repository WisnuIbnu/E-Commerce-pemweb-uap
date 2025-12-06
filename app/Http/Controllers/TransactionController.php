<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['items.product.images'])
            ->where('buyer_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        $transaction->load(['items.product.images', 'items.product.store']);

        return view('transactions.show', compact('transaction'));
    }

    public function cancel(Transaction $transaction)
    {
        if ($transaction->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized access');
        }

        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $transaction->update(['status' => 'cancelled']);

        return back()->with('success', 'Order cancelled successfully.');
    }
}