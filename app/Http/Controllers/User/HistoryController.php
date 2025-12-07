<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buyer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HistoryController extends Controller
{
    public function index(): View
    {
        // cari buyer berdasarkan user yang login
        $buyer = Buyer::where('user_id', Auth::id())->first();

        $transactions = $buyer
            ? $buyer->transactions()->with('store')->latest()->get()
            : collect(); // kosong kalau user belum pernah jadi buyer

        return view('user.history.history', compact('transactions'));
    }
}
