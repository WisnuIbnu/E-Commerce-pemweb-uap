<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = auth()->user()->store;
        
        // Ambil data withdrawals dari store balance
        $withdrawals = $store->balance 
            ? $store->balance->withdrawals()->latest()->get() 
            : collect();

        return view('seller.withdrawals.index', compact('withdrawals', 'store'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = auth()->user()->store;
        
        // Validate withdrawal request
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:10000'],
            'bank' => ['required', 'string'],
            'account_number' => ['required', 'string'],
            'account_name' => ['required', 'string'],
        ]);

        // Check if store has balance
        if (!$store->balance) {
            return redirect()->back()->with('error', 'Store balance not initialized.');
        }

        // Check if sufficient balance
        if ($store->balance->balance < $validated['amount']) {
            return redirect()->back()->with('error', 'Insufficient balance.');
        }

        // Create withdrawal request
        $withdrawal = \App\Models\Withdrawal::create([
            'store_balance_id' => $store->balance->id,
            'amount' => $validated['amount'],
            'bank_name' => $validated['bank'],
            'bank_account_number' => $validated['account_number'],
            'bank_account_name' => $validated['account_name'],
            'status' => 'pending',
        ]);

        // Decrement Store Balance
        $store->balance->decrement('balance', $validated['amount']);

        // Record Balance History
        \App\Models\StoreBalanceHistory::create([
            'store_balance_id' => $store->balance->id,
            'type' => 'withdraw',
            'reference_id' => $withdrawal->id,
            'reference_type' => \App\Models\Withdrawal::class,
            'amount' => $validated['amount'], // Positive or negative? Model has decimal amount. 
            // Checkout used positive for income. Logic usually is: type determines sign, or amount determines sign.
            // Let's use negative for withdraw to be safe structurally, or positive if display logic handles it.
            // Previous code used negative. Schema just says decimal.
            // Let's stick to negative for debit to be clear it reduces balance, 
            // UNLESS type 'withdraw' implies it.
            // Let's check schema: `type` enum ['income', 'withdraw'].
            // If I put negative, it effectively subtracts.
            'amount' => -$validated['amount'], 
            'remarks' => 'Withdrawal request #' . $withdrawal->id,
        ]);

        return redirect()->route('seller.withdrawals.index')
            ->with('success', 'Withdrawal request submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
