<?php

// app/Http/Controllers/Seller/WithdrawalController.php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;
        $withdrawals = $store->withdrawals()->latest()->paginate(15);

        return view('seller.withdrawals.index', compact('store', 'withdrawals'));
    }

    public function create()
    {
        $store = auth()->user()->store;
        
        if ($store->balance < 50000) {
            return redirect()->route('seller.balance.index')
                ->with('error', 'Minimum withdrawal amount is Rp 50,000');
        }

        return view('seller.withdrawals.create', compact('store'));
    }

    public function store(Request $request)
    {
        $store = auth()->user()->store;

        $validated = $request->validate([
            'amount' => 'required|numeric|min:50000|max:' . $store->balance,
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:255',
            'notes' => 'nullable|string'
        ]);

        // Check if balance is sufficient
        if ($validated['amount'] > $store->balance) {
            return back()->with('error', 'Insufficient balance');
        }

        $validated['store_id'] = $store->id;
        $validated['status'] = 'pending';

        Withdrawal::create($validated);

        // Deduct from store balance
        $store->decrement('balance', $validated['amount']);

        return redirect()->route('seller.withdrawals.index')
            ->with('success', 'Withdrawal request submitted successfully!');
    }
}
