<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTransactionController extends Controller
{
    /**
     * List transaksi milik user yang login
     */
    public function index()
    {
        $user = Auth::user();

        // Ambil semua transaksi yang buyer-nya punya user_id = user yang login
        $transactions = Transaction::with('transactionDetails.product.store', 'buyer')
            ->whereHas('buyer', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->latest()
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Detail 1 transaksi (halaman pembayaran)
     */
    public function show($id)
    {
        $user = Auth::user();

        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with('transactionDetails.product.store', 'buyer')
            ->findOrFail($id);

        // Cek kepemilikan: kalau buyer.user_id beda dengan user login → forbidden
        if ($transaction->buyer && $transaction->buyer->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses ke transaksi ini.');
        }

        return view('transactions.show', compact('transaction'));
    }

    /**
     * Proses "Saya sudah bayar"
     */
    public function pay(Request $request, $id)
    {
        $user = Auth::user();

        $transaction = Transaction::with('buyer')
            ->findOrFail($id);

        if ($transaction->buyer && $transaction->buyer->user_id !== $user->id) {
            abort(403, 'Anda tidak punya akses ke transaksi ini.');
        }

        $transaction->update([
            'payment_status' => Transaction::STATUS_PAID,
            'payment_method' => $request->payment_method ?? 'manual',
        ]);

        return redirect()
            ->route('transactions.show', $transaction->id)
            ->with('success', 'Pembayaran berhasil, terima kasih!');
    }
}
