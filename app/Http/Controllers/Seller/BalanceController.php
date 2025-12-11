<?php

// app/Http/Controllers/Seller/BalanceController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $balance = $store->balance;
        
        $history = $balance->histories()
            ->latest()
            ->paginate(15);
        
        return view('seller.balance.index', compact('balance', 'history'));
    }
}