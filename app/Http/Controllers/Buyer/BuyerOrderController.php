<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $buyerId = auth()->user()->buyer->id ?? null;
        
        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        // Ambil orders dengan pagination (15 per halaman)
        $orders = Transaction::where('buyer_id', $buyerId)
            ->with('transactionDetails.product.images') // Eager load details dan product
            ->latest()
            ->paginate(15);
        
        return view('buyer.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $buyerId = auth()->user()->buyer->id ?? null;

        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        // Cari transaction berdasarkan ID dan buyer_id
        $order = Transaction::where('buyer_id', $buyerId)
            ->with('transactionDetails.product.images', 'store')
            ->findOrFail($id);
        
        return view('buyer.orders.show', compact('order'));
    }
    
    public function cancel($id)
    {
        $buyerId = auth()->user()->buyer->id ?? null;

        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        try {
            $order = Transaction::where('buyer_id', $buyerId)
                ->findOrFail($id);

            // Hanya bisa cancel kalau status unpaid
            if ($order->payment_status !== 'unpaid') {
                return redirect()->back()
                    ->with('error', 'Hanya pesanan yang belum dibayar yang bisa dibatalkan');
            }

            // Jangan ubah payment_status, hapus dari database saja
            $order->delete();

            return redirect()->route('buyer.orders.index')
                ->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function confirmReceived($id)
    {
        $buyerId = auth()->user()->buyer->id ?? null;

        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        try {
            $order = Transaction::where('buyer_id', $buyerId)
                ->findOrFail($id);

            // Hanya bisa confirm kalau status paid (sudah bayar)
            if ($order->payment_status !== 'paid') {
                return redirect()->back()
                    ->with('error', 'Hanya pesanan yang sudah dibayar yang bisa dikonfirmasi');
            }

            $order->update(['payment_status' => 'paid']); // Keep as paid, just mark as confirmed

            return redirect()->route('buyer.orders.show', $order->id)
                ->with('success', 'Pesanan dikonfirmasi diterima');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function payment($id)
    {
        $buyerId = auth()->user()->buyer->id ?? null;

        if (!$buyerId) {
            return redirect()->route('buyer.dashboard')
                ->with('error', 'Data buyer tidak ditemukan');
        }

        try {
            $order = Transaction::where('buyer_id', $buyerId)
                ->findOrFail($id);

            // Hanya bisa bayar kalau status unpaid
            if ($order->payment_status !== 'unpaid') {
                return redirect()->back()
                    ->with('error', 'Pesanan ini sudah dibayar atau dibatalkan');
            }

            // Update payment status menjadi paid
            $order->update(['payment_status' => 'paid']);

            return redirect()->route('buyer.orders.show', $order->id)
                ->with('success', 'Pembayaran berhasil! Pesanan sedang diproses');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}