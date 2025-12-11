<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Display a listing of withdrawal requests.
     */
    public function index()
    {
        $withdrawals = Withdrawal::with(['storeBalance.store'])
            ->latest()
            ->paginate(20);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Approve a withdrawal request.
     */
    public function approve($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Withdrawal already processed.');
        }

        DB::transaction(function () use ($withdrawal) {
            // Update withdrawal status
            $withdrawal->update(['status' => 'approved']);

            // Deduct balance from store
            $storeBalance = $withdrawal->storeBalance;
            $storeBalance->decrement('balance', $withdrawal->amount);

            // Create balance history
            \App\Models\StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'type' => 'withdraw',
                'reference_id' => $withdrawal->id,
                'reference_type' => 'App\Models\Withdrawal',
                'amount' => $withdrawal->amount,
                'remarks' => 'Withdrawal approved - ' . $withdrawal->bank_name . ' ' . $withdrawal->bank_account_number,
            ]);
        });

        return redirect()->back()->with('success', 'Withdrawal approved successfully.');
    }

    /**
     * Reject a withdrawal request.
     */
    public function reject($id)
    {
        $withdrawal = Withdrawal::findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Withdrawal already processed.');
        }

        $withdrawal->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Withdrawal rejected.');
    }
}
