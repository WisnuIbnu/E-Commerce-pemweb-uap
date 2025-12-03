<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class WithdrawalController extends Controller
{
    // Tampilkan semua withdrawal request
    public function index()
    {
        $withdrawals = Withdrawal::with('storeBalance.store.user')
            ->latest()
            ->paginate(10);

        return view('admin.withdrawals', compact('withdrawals'));
    }

    // Approve atau Reject withdrawal
    public function updateStatus(Request $request, Withdrawal $withdrawal)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $oldStatus = $withdrawal->status;
        $withdrawal->update(['status' => $request->status]);

        // Jika rejected, kembalikan saldo ke toko
        if ($request->status === 'rejected' && $oldStatus === 'pending') {
            $storeBalance = $withdrawal->storeBalance;
            $storeBalance->increment('balance', $withdrawal->amount);
            
            // Catat di history
            $storeBalance->storeBalanceHistories()->create([
                'type' => 'credit',
                'reference_id' => $withdrawal->id,
                'reference_type' => 'App\Models\Withdrawal',
                'amount' => $withdrawal->amount,
                'remarks' => 'Withdrawal ditolak, saldo dikembalikan',
            ]);
        }

        $message = $request->status === 'approved' 
            ? 'Withdrawal berhasil diapprove!' 
            : 'Withdrawal ditolak, saldo dikembalikan!';

        return back()->with('success', $message);
    }
}