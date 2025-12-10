<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Withdrawal;
use Illuminate\Http\Request;

class SellerWithdrawController extends Controller
{
    public function index()
    {
        $store = auth()->user()->store;

        // Total revenue dari transaksi yang sudah dibayar
        $totalRevenue = Transaction::where('payment_status', 'paid')
            ->whereHas('transactionDetails', function ($q) use ($store) {
                $q->whereHas('product', function ($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->sum('grand_total');

        // Total penarikan yang sudah approved
        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');

        // Saldo tersisa
        $availableBalance = $totalRevenue - $totalWithdrawn;

        return view('seller.withdraw.index', compact('store', 'availableBalance'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount'         => 'required|numeric|min:50000',
            'bank_name'      => 'required|string',
            'account_name'   => 'required|string',
            'account_number' => 'required|string',
        ]);

        $store = auth()->user()->store;

        // Hitung ulang total revenue (paid only)
        $totalRevenue = Transaction::where('payment_status', 'paid')
            ->whereHas('transactionDetails', function ($q) use ($store) {
                $q->whereHas('product', function ($q2) use ($store) {
                    $q2->where('store_id', $store->id);
                });
            })
            ->sum('grand_total');

        $totalWithdrawn = $store->withdrawals()
            ->where('status', 'approved')
            ->sum('amount');

        $availableBalance = $totalRevenue - $totalWithdrawn;

        // Cek saldo
        if ($request->amount > $availableBalance) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        // Simpan withdraw baru
        Withdrawal::create([
            'store_id'       => $store->id,
            'amount'         => $request->amount,
            'bank_name'      => $request->bank_name,
            'account_name'   => $request->account_name,
            'account_number' => $request->account_number,
            'status'         => 'pending',
        ]);

        return redirect()->route('seller.withdraw.history')
            ->with('success', 'Permintaan penarikan berhasil diajukan.');
    }

    public function history()
    {
        $store = auth()->user()->store;

        $withdrawals = $store->withdrawals()
            ->latest()
            ->paginate(20);

        return view('seller.withdraw.history', compact('store', 'withdrawals'));
    }
}
