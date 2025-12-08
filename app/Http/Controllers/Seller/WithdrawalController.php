<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $withdrawals = $store->withdrawals ?? [];

        return view('seller.withdrawals.index', compact('store', 'withdrawals'));
    }

    public function requestWithdraw(Request $request)
    {
        $request->validate([
            'bank_name' => 'required',
            'account_name' => 'required',
            'account_number' => 'required',
            'amount' => 'required|numeric|min:10000'
        ]);

        $store = Auth::user()->store;

        if ($store->balance < $request->amount) {
            return back()->with('error', 'Balance not enough.');
        }

        $store->withdrawals()->create([
            'bank_name' => $request->bank_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        $store->balance -= $request->amount;
        $store->save();

        return back()->with('success', 'Withdrawal request submitted!');
    }
}
