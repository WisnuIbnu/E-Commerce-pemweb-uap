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
        // Ambil data order milik user yang sedang login
        $transactions = \App\Models\Order::with('store')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('user.history.history', compact('transactions'));
    }
}
