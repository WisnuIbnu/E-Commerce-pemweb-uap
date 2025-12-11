<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Ambil atau buat store balance
        $balance = $store->balance;

        if (! $balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0,
            ]);
        }

        // Ambil riwayat balance berdasarkan store_balance_id
        $histories = StoreBalanceHistory::where('store_balance_id', $balance->id)
            ->latest()
            ->paginate(20);

        // Ambil riwayat withdrawal berdasarkan store_balance_id
        $withdrawals = Withdrawal::where('store_balance_id', $balance->id)
            ->latest()
            ->paginate(20);

        return view('seller.balance.index', compact('balance', 'histories', 'withdrawals'));
    }

    public function withdraw(Request $request)
    {
        $store = auth()->user()->store;
        $balance = $store->balance;

        if (! $balance) {
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0,
            ]);
        }

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bank_name' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:255',
        ]);

        if ($request->amount > $balance->balance) {
            return back()->withErrors(['amount' => 'Saldo tidak mencukupi']);
        }

        // Kurangi saldo
        $balance->balance -= $request->amount;
        $balance->save();

        // Catat history
        StoreBalanceHistory::create([
            'store_balance_id' => $balance->id,
            'type' => 'withdraw',
            'reference_id' => \Str::uuid(),
            'reference_type' => 'withdrawal',
            'amount' => $request->amount,
            'remarks' => 'Withdrawal request',
        ]);

        // Buat withdrawal request
        Withdrawal::create([
            'store_balance_id' => $balance->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Withdrawal request submitted!');
    }
}