<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Orders for seller — tampilkan pesanan yang berhubungan dengan store seller.
     */
    public function sellerOrders()
    {
        // temukan store id pemilik saat ini
        $store = Auth::user()->store;
        if (!$store) {
            abort(403, 'Anda bukan penjual atau belum mendaftar toko.');
        }

        $orders = Transaction::where('store_id', $store->id)
            ->latest()
            ->paginate(12);

        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Update shipping (kirim / set tracking number)
     */
    public function shipOrder(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $transaction = Transaction::where('id', $id)
            ->where('store_id', Auth::user()->store->id)
            ->firstOrFail();

        $transaction->tracking_number = $request->tracking_number;
        // you can add shipping status if your DB has 'shipping_status'
        if ($request->has('mark_shipped')) {
            // $transaction->shipping_status = 'shipped';
            $transaction->shipped_at = now(); // only if column exists
        }
        $transaction->save();

        return back()->with('success','Informasi pengiriman tersimpan.');
    }
}
