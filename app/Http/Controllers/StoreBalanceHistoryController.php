<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreBalanceHistoryController extends Controller
{
    public function view(): View
    {
        $storeId = Auth::user()->store->id;
        $balance = StoreBalance::where('store_id', $storeId)->first();
        $history = StoreBalanceHistory::where('store_balance_id', $balance->id)->get();
        return view('store.balance-history', ['history' => $history, 'balance' => $balance]);
    }
}
