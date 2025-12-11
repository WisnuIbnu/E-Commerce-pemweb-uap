<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi yang buyer-nya punya user_id = user yang login
        $transactions = Transaction::with(['transactionDetails.product.store', 'buyer'])
            ->whereHas('buyer', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $user = Auth::user();

        // Ambil transaksi + relasi
        $transaction = Transaction::with(['transactionDetails.product.store', 'buyer', 'store'])
            ->findOrFail($id);

        // Cek kepemilikan: kalau buyer.user_id beda dengan user login → forbidden
        if ($transaction->buyer && $transaction->buyer->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses ke transaksi ini.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Buyer klik "Saya sudah bayar"
     * → status jadi waiting_confirmation (menunggu konfirmasi admin)
     */
    public function pay(Request $request, $id)
    {
        $user = Auth::user();

        // Validasi optional payment_method
        $data = $request->validate([
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        // Ambil transaksi + buyer
        $transaction = Transaction::with('buyer')->findOrFail($id);

        // Cek kepemilikan
        if ($transaction->buyer && $transaction->buyer->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses ke transaksi ini.');
        }

        // Hanya bisa konfirmasi kalau masih pending
        if ($transaction->payment_status !== Transaction::STATUS_PENDING) {
            return redirect()
                ->route('transactions.show', $transaction->id)
                ->with('error', 'Transaksi ini sudah tidak bisa dikonfirmasi (status: ' . $transaction->payment_status . ').');
        }

        // Ubah jadi menunggu konfirmasi admin
        $transaction->update([
            'payment_status' => Transaction::STATUS_WAITING_CONFIRMATION,
            'payment_method' => $data['payment_method'] ?? ($transaction->payment_method ?? 'manual'),
        ]);

        return redirect()
            ->route('transactions.show', $transaction->id)
            ->with('success', 'Konfirmasi pembayaran dikirim. Menunggu verifikasi admin.');
    }

    public function orders()
{
    $user = Auth::user();

    $query = Transaction::with(['transactionDetails.product.store', 'buyer'])
        ->whereHas('buyer', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        });

    // PESANAN YANG MASIH AKTIF:
    // - pembayaran: pending / waiting_confirmation / paid
    // - ATAU pengiriman: processing / packed / shipped
    $query->where(function ($q) {
        $q->whereIn('payment_status', ['pending', 'waiting_confirmation', 'paid'])
          ->orWhereIn('shipping', ['processing', 'packed', 'shipped']);
    });

    $orders = $query->latest()->paginate(10);

    return view('orders.index', compact('orders'));
}


    public function track($id)
    {
        $user = Auth::user();

        // Ambil transaksi + relasi
        $transaction = Transaction::with(['transactionDetails.product.store', 'buyer'])
            ->findOrFail($id);

        // Pastikan pesanan ini milik user
        if ($transaction->buyer->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses ke pesanan ini.');
        }

        return view('orders.track', compact('transaction'));
    }
}
