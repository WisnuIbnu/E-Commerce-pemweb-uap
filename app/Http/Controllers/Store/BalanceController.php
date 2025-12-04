<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Transaction;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $balance = $store->balance;

        // Get balance history
        $history = Transaction::where('store_id', $store->id)
            ->where('payment_status', 'delivered')
            ->latest()
            ->paginate(10);

        return view('store.balance.index', compact('balance', 'history'));
    }
}