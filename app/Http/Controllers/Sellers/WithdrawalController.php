<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    // Tampilkan halaman withdrawal + history
    public function index()
{
    $storeBalance = Auth::user()->store->balance; // asumsi relasi Store -> balance
    $withdrawals = $storeBalance ? $storeBalance->withdrawals()->latest()->get() : collect();

    return view('seller.withdrawals.index', compact('storeBalance', 'withdrawals'));
}

public function requestWithdraw(Request $request)
{
    $request->validate([
        'bank_name' => 'required|string|max:255',
        'bank_account_name' => 'required|string|max:255',
        'bank_account_number' => 'required|string|max:50',
        'amount' => 'required|numeric|min:10000'
    ]);

    $storeBalance = Auth::user()->store->balance;

    if (!$storeBalance) {
        return back()->with('error', 'Store balance not found.');
    }

    if ($storeBalance->amount < $request->amount) {
        return back()->with('error', 'Balance not enough.');
    }

    $storeBalance->withdrawals()->create([
        'bank_name' => $request->bank_name,
        'bank_account_name' => $request->bank_account_name,
        'bank_account_number' => $request->bank_account_number,
        'amount' => $request->amount,
        'status' => 'pending'
    ]);

    // kurangi balance
    $storeBalance->amount -= $request->amount;
    $storeBalance->save();

    return back()->with('success', 'Withdrawal request submitted!');
}

}