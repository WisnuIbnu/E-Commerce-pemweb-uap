<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreBalance;
use App\Models\Withdrawal;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerWithdrawalController extends Controller
{

    protected function sellerStore()
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }
    
    public function index()
    {
        // Ambil toko milik seller yang login
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        // Pastikan store_balance ada
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $availableBalance = $storeBalance->balance;

        // Hitung saldo tersedia (kalau kamu sudah punya fungsi khusus, pakai itu)
        $totalSales = \App\Models\Transaction::where('store_id', $store->id)
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        $totalWithdrawn = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->whereIn('status', ['approved', 'paid'])
            ->sum('amount');

        $availableBalance = max($totalSales - $totalWithdrawn, 0);

        // Riwayat penarikan
        $withdrawals = Withdrawal::where('store_balance_id', $storeBalance->id)
            ->latest()
            ->paginate(10);

        return view('seller.withdrawals.index', [
            'store'            => $store,
            'availableBalance' => $availableBalance,
            'withdrawals'      => $withdrawals,
        ]);
    }

    public function store(Request $request)
    {
        $store = $this->sellerStore();
        $storeBalance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        $data = $request->validate([
            'amount' => ['required', 'integer', 'min:50000'],
            'note'   => ['nullable', 'string', 'max:255'],
        ]);

        // 1. pastikan saldo cukup
        if ($data['amount'] > $storeBalance->balance) {
            return back()->withErrors([
                'amount' => 'Saldo tidak mencukupi untuk penarikan ini.',
            ]);
        }

        // 2. pastikan data bank sudah lengkap
        if (! $store->bank_name || ! $store->bank_account_number || ! $store->bank_account_name) {
            return back()->withErrors([
                'bank' => 'Lengkapi data rekening bank di Pengaturan Toko sebelum melakukan penarikan.',
            ]);
        }

        Withdrawal::create([
            'store_balance_id'   => $storeBalance->id,
            'amount'             => $data['amount'],
            'status'             => 'pending',
            'method'             => 'bank_transfer',
            'bank_name'          => $store->bank_name,
            'bank_account'       => $store->bank_account_number,
            'bank_account_name'  => $store->bank_account_name,
            'note'               => $data['note'] ?? null,
        ]);

        return back()->with('success', 'Pengajuan penarikan berhasil dikirim. Menunggu persetujuan admin.');
    }
}
