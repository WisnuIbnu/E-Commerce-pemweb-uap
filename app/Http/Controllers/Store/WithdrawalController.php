<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $balance = $store->balance->balance ?? 0;
        
        $withdrawals = Withdrawal::where('store_id', $store->id)
            ->latest()
            ->paginate(10);

        return view('store.withdrawal.index', compact('balance', 'withdrawals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100',
        ]);

        $store = auth()->user()->store;
        $balance = $store->balance->balance ?? 0;

        if ($request->amount > $balance) {
            return back()->with('error', 'Insufficient balance');
        }

        Withdrawal::create([
            'store_id' => $store->id,
            'amount' => $request->amount,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_name' => $request->bank_name,
            'status' => 'pending',
        ]);

        // Deduct balance
        $store->balance->decrement('balance', $request->amount);

        return redirect()->route('store.withdrawal.index')
            ->with('success', 'Withdrawal request submitted successfully');
    }

    public function updateBankAccount(Request $request)
    {
        $request->validate([
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
            'bank_name' => 'required|string|max:100',
        ]);

        // Store in session or database as needed
        session()->put('bank_account', [
            'name' => $request->bank_account_name,
            'number' => $request->bank_account_number,
            'bank' => $request->bank_name,
        ]);

        return back()->with('success', 'Bank account information updated');
    }
}