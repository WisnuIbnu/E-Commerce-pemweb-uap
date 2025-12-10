<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Transaction;
use App\Models\StoreBalance;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id], 
            ['balance' => 0]
        );
        
        $balance = $storeBalance->balance;
        
        $withdrawals = Withdrawal::where('store_balance_id', $storeBalance->id)  
            ->latest()
            ->paginate(10);

        $history = Transaction::whereHas('transactionDetails.product', function($query) use ($store) {
                $query->where('store_id', $store->id);
            })
            ->whereIn('payment_status', ['paid', 'delivered'])
            ->with(['buyer', 'transactionDetails'])
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'history_page');

        return view('store.withdrawal.index', compact('balance', 'withdrawals', 'history'));
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
        
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );
        
        $balance = $storeBalance->balance;

        if ($request->amount > $balance) {
            return back()->with('error', 'Insufficient balance');
        }

        $withdrawal = Withdrawal::create([
            'store_balance_id' => $storeBalance->id,  
            'amount' => $request->amount,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
            'bank_name' => $request->bank_name,
            'status' => 'pending',
        ]);

        $storeBalance->deductBalance(
            $request->amount,
            'App\Models\Withdrawal',
            $withdrawal->id,
            'Withdrawal request #' . $withdrawal->id
        );

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

        session()->put('bank_account', [
            'name' => $request->bank_account_name,
            'number' => $request->bank_account_number,
            'bank' => $request->bank_name,
        ]);

        return back()->with('success', 'Bank account information updated');
    }
}