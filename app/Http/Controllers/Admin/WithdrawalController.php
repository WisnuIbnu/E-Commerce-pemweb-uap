<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    /**
     * Display list of withdrawal requests
     */
    public function index(Request $request)
    {
        $query = Withdrawal::with('storeBalance.store.user');

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by store name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('storeBalance.store', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $withdrawals = $query->latest()->paginate(15);

        // Statistics
        $totalWithdrawals = Withdrawal::count();
        $pendingWithdrawals = Withdrawal::where('status', 'pending')->count();
        $approvedWithdrawals = Withdrawal::where('status', 'approved')->count();
        $rejectedWithdrawals = Withdrawal::where('status', 'rejected')->count();
        $totalAmount = Withdrawal::where('status', 'approved')->sum('amount');

        return view('admin.withdrawals.index', compact(
            'withdrawals',
            'totalWithdrawals',
            'pendingWithdrawals',
            'approvedWithdrawals',
            'rejectedWithdrawals',
            'totalAmount'
        ));
    }

    /**
     * Display withdrawal detail
     */
    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load('storeBalance.store.user');

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Approve withdrawal
     */
    public function approve(Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal is already processed');
        }

        DB::beginTransaction();

        try {
            // Update withdrawal status
            $withdrawal->update(['status' => 'approved']);

            // Balance already deducted when request created
            // So we just need to update the history if needed

            DB::commit();

            // You can send notification email to store owner here
            // Mail::to($withdrawal->storeBalance->store->user->email)->send(new WithdrawalApproved($withdrawal));

            return back()->with('success', 'Withdrawal approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to approve withdrawal: ' . $e->getMessage());
        }
    }

    /**
     * Reject withdrawal
     */
    public function reject(Request $request, Withdrawal $withdrawal)
    {
        if ($withdrawal->status !== 'pending') {
            return back()->with('error', 'Withdrawal is already processed');
        }

        $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();

        try {
            // Update withdrawal status
            $withdrawal->update([
                'status' => 'rejected',
            ]);

            // Return balance to store
            $withdrawal->storeBalance->increment('balance', $withdrawal->amount);

            // Update history remark
            StoreBalanceHistory::where('reference_id', $withdrawal->id)
                ->where('reference_type', 'withdrawal')
                ->update([
                    'remarks' => 'Withdrawal request #' . $withdrawal->id . ' REJECTED'
                ]);

            DB::commit();

            // You can send notification email to store owner here
            // Mail::to($withdrawal->storeBalance->store->user->email)->send(new WithdrawalRejected($withdrawal));

            return back()->with('success', 'Withdrawal rejected. Balance returned to store.');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Failed to reject withdrawal: ' . $e->getMessage());
        }
    }
}
