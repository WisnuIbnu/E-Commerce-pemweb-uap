<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\StoreBalance;

class TransactionController extends Controller
{
    public function index()
    {
        // Ambil buyer_id dari tabel buyers berdasarkan user yang login
        $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            return view('user.transaction.index', [
                'transactions' => collect([])
            ]);
        }

        $transactions = Transaction::where('buyer_id', $buyer->id)
            ->with(['transactionDetails.product.images', 'transactionDetails.product.store'])
            ->latest()
            ->paginate(10);

        return view('user.transaction.index', compact('transactions'));
    }

    public function show($id)
    {
        // Ambil buyer_id dari tabel buyers
        $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            abort(404);
        }

        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->with(['transactionDetails.product.images', 'transactionDetails.product.store'])
            ->findOrFail($id);

        return view('user.transaction.show', compact('transaction'));
    }

    public function cancel($id)
    {
        // Ambil buyer_id dari tabel buyers
        $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            abort(404);
        }

        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'pending')
            ->findOrFail($id);

        $transaction->update(['payment_status' => 'cancelled']);

        // Restore stock
        foreach ($transaction->transactionDetails as $detail) {
            $detail->product->increment('stock', $detail->qty);
        }

        return back()->with('success', 'Order cancelled successfully');
    }

    /**
     * Konfirmasi pembayaran manual (jika tidak pakai payment gateway otomatis)
     */
    public function confirmPayment($id)
    {
        // Ambil buyer_id dari tabel buyers
        $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            abort(404);
        }

        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->where('payment_status', 'pending')
            ->findOrFail($id);

        $oldStatus = $transaction->payment_status;

        // Update ke paid
        $transaction->update(['payment_status' => 'paid']);

        // Tambahkan saldo ke semua seller yang terlibat
        if (!in_array($oldStatus, ['paid', 'delivered'])) {
            $this->addBalanceToSellers($transaction);
        }

        return back()->with('success', 'Payment confirmed successfully');
    }

    /**
     * Konfirmasi barang diterima
     */
    public function confirmReceived($id)
    {
        // Ambil buyer_id dari tabel buyers
        $buyer = \App\Models\Buyer::where('user_id', auth()->id())->first();

        if (!$buyer) {
            abort(404);
        }

        $transaction = Transaction::where('buyer_id', $buyer->id)
            ->whereIn('payment_status', ['paid', 'processing', 'shipped'])
            ->findOrFail($id);

        $oldStatus = $transaction->payment_status;

        // Update ke delivered
        $transaction->update(['payment_status' => 'delivered']);

        // Jika sebelumnya belum paid, tambahkan saldo sekarang
        if (!in_array($oldStatus, ['paid', 'delivered'])) {
            $this->addBalanceToSellers($transaction);
        }

        return back()->with('success', 'Order marked as received successfully');
    }

    /**
     * Tambahkan saldo ke semua seller yang terlibat dalam transaksi
     */
    protected function addBalanceToSellers($transaction)
    {
        // Load relasi jika belum
        $transaction->load('transactionDetails.product.store');

        // Group products by store
        $storeEarnings = [];
        
        foreach ($transaction->transactionDetails as $detail) {
            $storeId = $detail->product->store_id;
            $earning = $detail->price * $detail->qty;
            
            if (!isset($storeEarnings[$storeId])) {
                $storeEarnings[$storeId] = 0;
            }
            $storeEarnings[$storeId] += $earning;
        }

        // Update saldo setiap store
        foreach ($storeEarnings as $storeId => $earning) {
            $balance = StoreBalance::firstOrCreate(
                ['store_id' => $storeId],
                ['balance' => 0]
            );
            
            // Cek apakah transaksi ini sudah pernah ditambahkan (prevent duplicate)
            $existingHistory = $balance->history()
                ->where('reference_type', 'App\Models\Transaction')
                ->where('reference_id', $transaction->id)
                ->where('type', 'income')
                ->exists();

            // Jika belum pernah ditambahkan, tambahkan saldo dan catat ke history
            if (!$existingHistory) {
                $balance->addBalance(
                    $earning,
                    'App\Models\Transaction',
                    $transaction->id,
                    'Order #' . $transaction->id . ' completed'
                );
            }
        }
    }
}