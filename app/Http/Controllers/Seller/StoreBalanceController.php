<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class StoreBalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $transactions = $store->transactions ?? [];

        return view('seller.balance.index', compact('store', 'transactions'));
    }
}
