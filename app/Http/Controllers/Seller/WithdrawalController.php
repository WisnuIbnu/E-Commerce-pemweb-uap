<?php

// app/Http/Controllers/Seller/WithdrawalController.php
namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        $withdrawals = Withdrawal::where('store_id', $store->id)
            ->latest()
            ->paginate(10);
        
        return view('seller.withdrawals.index', compact('store', 'withdrawals'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:50000',
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
        ]);
        
        $store = Auth::user()->store;
        $balance = $store->balance;
        
        if ($validated['amount'] > $balance->balance) {
            return back()->with('error', 'Insufficient balance');
        }
        
        DB::beginTransaction();
        try {
            // Create withdrawal
            Withdrawal::create([
                'store_id' => $store->id,
                'amount' => $validated['amount'],
                'bank_name' => $validated['bank_name'],
                'bank_account_name' => $validated['bank_account_name'],
                'bank_account_number' => $validated['bank_account_number'],
                'status' => 'pending',
            ]);
            
            // Deduct balance
            $balance->decrement('balance', $validated['amount']);
            
            // Record history
            StoreBalanceHistory::create([
                'store_balance_id' => $balance->id,
                'type' => 'debit',
                'reference_type' => 'withdrawal',
                'amount' => $validated['amount'],
                'remarks' => 'Withdrawal request',
            ]);
            
            DB::commit();
            return back()->with('success', 'Withdrawal request submitted!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Withdrawal failed');
        }
    }
    
    public function updateBank(Request $request)
    {
        $validated = $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:255',
            'bank_account_number' => 'required|string|max:50',
        ]);
        
        $store = Auth::user()->store;
        
        // Store in session or update store model if you add these fields
        session($validated);
        
        return back()->with('success', 'Bank information updated!');
    }
}