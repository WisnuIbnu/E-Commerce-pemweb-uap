<?php

namespace App\Http\Controllers;

use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StoreBalanceController extends Controller
{
    public function view(): View
    {
        $balance = StoreBalance::where('store_id', auth()->user()->store->id)->first();
        return view('store.balance', ['balance' => $balance]);
    }
}
