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
    public function index()
    {
        $withdrawals = Withdrawal::with(['storeBalance.store.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Hitung statistik
        $stats = [
            'pending' => Withdrawal::where('status', 'pending')->count(),
            'approved' => Withdrawal::where('status', 'approved')->count(),
            'rejected' => Withdrawal::where('status', 'rejected')->count(),
            'total_amount' => Withdrawal::where('status', 'approved')->sum('amount'),
        ];

        return view('admin.withdrawals.index', compact('withdrawals', 'stats'));
    }

    public function show($id)
    {
        $withdrawal = Withdrawal::with(['storeBalance.store.user'])->findOrFail($id);

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    public function approve($id)
    {
        try {
            DB::beginTransaction();

            $withdrawal = Withdrawal::findOrFail($id);

            if ($withdrawal->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Penarikan ini sudah diproses sebelumnya.');
            }

            $storeBalance = $withdrawal->storeBalance;

            // Cek apakah saldo mencukupi
            if ($storeBalance->balance < $withdrawal->amount) {
                return redirect()->back()
                    ->with('error', 'Saldo toko tidak mencukupi untuk penarikan ini.');
            }

            // Update status withdrawal
            $withdrawal->status = 'approved';
            $withdrawal->approved_at = now();
            $withdrawal->save();

            // Kurangi saldo
            $storeBalance->balance -= $withdrawal->amount;
            $storeBalance->save();

            // Buat history
            StoreBalanceHistory::create([
                'store_balance_id' => $storeBalance->id,
                'type' => 'withdraw',
                'reference_id' => $withdrawal->id,
                'reference_type' => 'App\Models\Withdrawal',
                'amount' => $withdrawal->amount,
                'remarks' => 'Penarikan dana disetujui ke ' . $withdrawal->bank_name . ' - ' . $withdrawal->bank_account_number,
            ]);

            DB::commit();

            return redirect()->route('admin.withdrawals.index')
                ->with('success', 'Penarikan dana berhasil disetujui dan saldo telah dikurangi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $withdrawal = Withdrawal::findOrFail($id);

            if ($withdrawal->status !== 'pending') {
                return redirect()->back()
                    ->with('error', 'Penarikan ini sudah diproses sebelumnya.');
            }

            // Update status withdrawal
            $withdrawal->status = 'rejected';
            $withdrawal->rejection_reason = $request->rejection_reason;
            $withdrawal->rejected_at = now();
            $withdrawal->save();

            DB::commit();

            return redirect()->route('admin.withdrawals.index')
                ->with('success', 'Penarikan dana berhasil ditolak.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
