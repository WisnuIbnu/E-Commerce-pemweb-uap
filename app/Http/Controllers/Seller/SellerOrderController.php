<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction; 

class SellerOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan KHUSUS milik toko yang sedang login.
     */
    public function index()
    {
        // 1. Ambil Toko milik user yang sedang login
        $user = Auth::user();
        
        // Cek keamanan: Pastikan user punya toko
        if (!$user->store) {
            return redirect()->route('stores.create');
        }

        // 2. Query Transaksi (Pesanan)
        // KUNCI LOGIKA: Ambil transaksi di mana 'store_id' sama dengan ID toko saya
        $orders = Transaction::where('store_id', $user->store->id)
            ->with(['buyer.user', 'details.product']) // Load relasi agar efisien
            ->latest()
            ->paginate(10);
            
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan.
     */
    public function show($id)
    {
        // Ambil transaksi berdasarkan ID
        $transaction = Transaction::with(['buyer.user', 'details.product'])
            ->findOrFail($id);

        // KEAMANAN DATA: 
        // Cek apakah transaksi ini benar-benar milik toko si user yang login?
        // Jika tidak, blokir aksesnya. (Mencegah penjual A mengintip order penjual B)
        if ($transaction->store_id !== Auth::user()->store->id) {
            abort(403, 'Pesanan ini bukan milik toko Anda.');
        }

        return view('seller.orders.show', compact('transaction'));
    }

    /**
     * Update status pengiriman dan nomor resi.
     */
    public function update(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        // Cek keamanan lagi
        if ($transaction->store_id !== Auth::user()->store->id) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'tracking_number' => 'nullable|string|max:255',
        ]);

        // Update data
        // Disini kita asumsikan jika resi diisi, status jadi 'shipping' (dikirim)
        if ($request->filled('tracking_number')) {
            $transaction->update([
                'tracking_number' => $request->tracking_number,
                'shipping' => 'shipping', // Update status pengiriman (sesuaikan kolom di DB Anda)
            ]);
        }

        return redirect()->route('seller.orders.show', $id)
            ->with('success', 'Informasi pesanan berhasil diperbarui.');
    }
}