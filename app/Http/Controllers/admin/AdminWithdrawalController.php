<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class AdminWithdrawalController extends Controller
{
    public function index(Request $request)
    {
        // optional filter ?status=pending / approved / rejected / paid
        $status = $request->query('status');

        $query = Withdrawal::with(['storeBalance.store'])
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $withdrawals = $query->paginate(20)->withQueryString();

        return view('admin.withdrawals.index', compact('withdrawals', 'status'));
    }

    public function show(Withdrawal $withdrawal)
    {
        $withdrawal->load(['storeBalance.store']);

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function update(Request $request, Withdrawal $withdrawal)
    {
        // status yang diizinkan
        $data = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,paid'],
        ]);

        $withdrawal->update([
            'status' => $data['status'],
        ]);

        return redirect()
            ->back()
            ->with('success', 'Status withdrawal berhasil diperbarui menjadi: ' . $data['status']);
    }
}