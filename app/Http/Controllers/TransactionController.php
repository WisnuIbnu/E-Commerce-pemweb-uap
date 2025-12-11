<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
public function index()
{
        $buyer = auth()->user()->buyer;

        if (!$buyer) {
            return view('transactions.index', ['transactions' => collect()]);
        }

        $transactions = Transaction::where('buyer_id', $buyer->id)
            ->latest()
            ->get();

        return view('transactions.index', compact('transactions'));
    }
}
