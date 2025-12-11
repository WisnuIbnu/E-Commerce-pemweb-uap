<?php
// app/Http/Controllers/Admin/WithdrawalController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = Withdrawal::with('store.buyer');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->latest()->paginate(15);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal is not pending approval');
        }

        $withdrawal->update([
            'status' => 'completed',
            'processed_at' => now()
        ]);

        // TODO: Send email notification to store owner

        return back()->with('success', 'Withdrawal approved successfully!');
    }

    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal is not pending approval');
        }

        $validated = $request->validate([
            'notes' => 'required|string|max:1000'
        ]);

        $withdrawal->update([
            'status' => 'rejected',
            'notes' => $validated['notes'],
            'processed_at' => now()
        ]);

        // Return balance to store
        $withdrawal->store->increment('balance', $withdrawal->amount);

        // TODO: Send email notification to store owner

        return back()->with('success', 'Withdrawal rejected successfully!');
    }
}
