<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        // Kalau ada tabel history, bisa fetch history juga
        $history = $balance->history()->orderBy('created_at', 'desc')->get(); // asumsikan relasi history

        return view('seller.balance.index', compact('balance', 'history'));
    }
}
