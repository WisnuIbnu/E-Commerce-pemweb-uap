<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Withdrawal;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator; // Tambahkan ini

class SellerWithdrawController extends Controller
{
    /**
     * Menampilkan halaman penarikan saldo & riwayat.
     */
    public function index()
    {
        $store = Auth::user()->store;
        $balance = $store->balance; 

        // PERBAIKAN DI SINI:
        // Pastikan $withdrawals selalu berupa Paginator, bukan Array biasa.
        if($balance) {
            $withdrawals = Withdrawal::where('store_balance_id', $balance->id)
                ->latest()
                ->paginate(10);
        } else {
            // Jika tidak ada saldo, buat Paginator kosong agar tidak error di View
            $withdrawals = new LengthAwarePaginator([], 0, 10);
        }

        return view('seller.withdraw.index', compact('store', 'balance', 'withdrawals'));
    }

    /**
     * Mengupdate informasi rekening bank toko.
     */
    public function updateBank(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'bank_account_name' => 'required|string|max:100',
            'bank_account_number' => 'required|numeric',
        ]);

        Auth::user()->store->update([
            'bank_name' => $request->bank_name,
            'bank_account_name' => $request->bank_account_name,
            'bank_account_number' => $request->bank_account_number,
        ]);

        return redirect()->back()->with('success', 'Informasi Bank berhasil diperbarui.');
    }

    /**
     * Memproses pengajuan penarikan saldo.
     */
    public function store(Request $request)
    {
        $store = Auth::user()->store;
        $balanceRecord = $store->balance;

        if(!$balanceRecord) {
             return redirect()->back()->with('error', 'Akun saldo toko belum aktif.');
        }

        $currentBalance = $balanceRecord->balance;

        $request->validate([
            'amount' => 'required|numeric|min:10000|max:' . $currentBalance,
        ], [
            'amount.max' => 'Saldo tidak mencukupi.',
            'amount.min' => 'Minimal penarikan Rp 10.000',
        ]);

        if (!$store->bank_name || !$store->bank_account_number) {
            return redirect()->back()->with('error', 'Harap lengkapi informasi Bank terlebih dahulu.');
        }

        DB::transaction(function () use ($request, $store, $balanceRecord, $currentBalance) {
            // 1. Kurangi Saldo
            $balanceRecord->update([
                'balance' => $currentBalance - $request->amount
            ]);

            // 2. Catat Withdrawal
            Withdrawal::create([
                'store_balance_id' => $balanceRecord->id,
                'amount' => $request->amount,
                'bank_name' => $store->bank_name,
                'bank_account_name' => $store->bank_account_name,
                'bank_account_number' => $store->bank_account_number,
                'status' => 'pending',
            ]);
        });

        return redirect()->back()->with('success', 'Permintaan penarikan berhasil dikirim!');
    }
}