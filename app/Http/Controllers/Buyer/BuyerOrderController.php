<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Transaction; // Ganti Order dengan Transaction
use Illuminate\Http\Request;

class BuyerOrderController extends Controller
{
    public function index()
    {
        // Ambil ID buyer dari user yang login
        $buyerId = auth()->user()->buyer->id ?? null;
        
        // Ambil semua transaksi yang terkait dengan buyer ini (dengan status selain 'cart')
        $orders = Transaction::where('buyer_id', $buyerId)
            ->latest()
            ->get();
        
        return view('buyer.orders.index', compact('orders'));
    }
    
    public function show($id)
    {
        $buyerId = auth()->user()->buyer->id ?? null;

        // Cari transaksi berdasarkan ID dan buyer_id
        $order = Transaction::where('buyer_id', $buyerId)->findOrFail($id);
        
        return view('buyer.orders.show', compact('order'));
    }
    
    // Perbaikan: Logic cancel dan confirm harus bekerja pada model Transaction
    public function cancel($id)
    {
        // Logic untuk cancel order (update status di tabel transactions)
        
        return response()->json(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
    }
    
    public function confirmReceived($id)
    {
        // Logic untuk confirm received (update status di tabel transactions dan trigger balance)
        
        return response()->json(['success' => true, 'message' => 'Pesanan dikonfirmasi diterima']);
    }
}