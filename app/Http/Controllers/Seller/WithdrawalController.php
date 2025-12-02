<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Withdrawal;
use App\Models\StoreBalance;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    // Tampilkan halaman penarikan & riwayat
    public function index()
    {
        $store = Auth::user()->store;
        $withdrawals = Withdrawal::where('store_id', $store->id)->orderBy('created_at', 'desc')->get();
        $balance = StoreBalance::firstOrCreate(['store_id' => $store->id], ['balance' => 0]);

        return view('seller.withdrawals.index', compact('withdrawals', 'balance'));
    }

    // Request penarikan dana
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000', // misal minimum penarikan
            'bank_name' => 'required|string|max:255',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
        ]);

        $store = Auth::user()->store;
        $balance = StoreBalance::firstOrCreate(['store_id' => $store->id], ['balance' => 0]);

        if ($request->amount > $balance->balance) {
            return redirect()->back()->withErrors(['amount' => 'Saldo tidak mencukupi']);
        }

        // Buat record withdrawal
        Withdrawal::create([
            'store_id' => $store->id,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'status' => 'pending',
        ]);

        // Kurangi saldo toko
        $balance->balance -= $request->amount;
        $balance->save();

        return redirect()->route('seller.withdrawals.index')
                         ->with('success', 'Request penarikan berhasil dibuat.');
    }
}
