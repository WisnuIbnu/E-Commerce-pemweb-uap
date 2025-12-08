<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Facades\DB;

class SellerOrderController extends Controller
{
    /**
     * Tampilkan daftar pesanan untuk toko seller.
     * View: order_management.blade.php
     */
    public function index()
    {
        $store = Auth::user()->store; // sudah dijamin ada & verified

        $orders = Transaction::with([
                'buyer',
                'transactionDetails.product',
            ])
            ->where('store_id', $store->id) // ownership: hanya pesanan ke toko ini
            ->latest()
            ->paginate(10);

        return view('seller.order_management', compact('orders', 'store'));
    }

    /**
     * Menampilkan detail pesanan lengkap.
     * View: order_detail.blade.php
     */
    public function show(Transaction $transaction)
    {
        $store = Auth::user()->store;

        // ownership check
        if ($transaction->store_id !== $store->id) {
            abort(403, 'Anda tidak berhak melihat pesanan ini.');
        }

        $transaction->load(['buyer', 'transactionDetails.product']);

        return view('seller.order_detail', compact('transaction'));
    }

    /**
     * Update status pembayaran pesanan (unpaid → paid).
     */
    public function updateStatus(Transaction $transaction)
    {
        $user  = Auth::user();
        $store = $user->store;

        if (! $store || $transaction->store_id !== $store->id) {
            abort(403, 'Anda tidak berhak memproses pesanan ini.');
        }

        // hanya boleh proses kalau status sudah "paid"
        if ($transaction->payment_status !== 'paid') {
            return redirect()
                ->route('seller.orders.index')
                ->with('error', 'Hanya pesanan yang sudah dibayar yang bisa diproses.');
        }

        // cek apakah transaksi ini sudah pernah dicatat sbg "income"
        $sudahMasukSaldo = StoreBalanceHistory::where('reference_type', Transaction::class)
            ->where('reference_id', $transaction->id)
            ->where('type', 'income')
            ->exists();

        if ($sudahMasukSaldo) {
            return redirect()
                ->route('seller.orders.index')
                ->with('success', 'Pesanan ini sudah pernah diproses. Saldo toko tidak akan bertambah lagi.');
        }

        DB::transaction(function () use ($store, $transaction) {
            // ambil / buat saldo toko
            $balance = StoreBalance::firstOrCreate(
                ['store_id' => $store->id],
                ['balance'  => 0]
            );
            $productSubtotal = $transaction->transactionDetails()->sum('subtotal');
            $balance->increment('balance', $productSubtotal);

            // riwayat saldo (income)
            StoreBalanceHistory::create([
                'store_balance_id' => $balance->id,
                'type'             => 'income',
                'reference_id'     => $transaction->id,
                'reference_type'   => Transaction::class,
                'amount'           => $productSubtotal,
                'remarks'          => 'Pendapatan dari pesanan ' . $transaction->code,
            ]);
        });

        return redirect()
            ->route('seller.orders.index')
            ->with('success', 'Pesanan diproses, saldo toko bertambah.');
    }

    /**
     * Update nomor resi (tracking number)
     */
    public function updateTracking(Request $request, Transaction $transaction)
    {
        $store = Auth::user()->store;

        if ($transaction->store_id !== $store->id) {
            abort(403, 'Anda tidak berhak mengubah nomor resi.');
        }

        $validated = $request->validate([
            'tracking_number' => ['required', 'string', 'max:255'],
        ]);

        $transaction->update(['tracking_number' => $validated['tracking_number']]);

        return redirect()
            ->route('seller.orders.index')
            ->with('success', 'Nomor resi berhasil diperbarui.');
    }
}
