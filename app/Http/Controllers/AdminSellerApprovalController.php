<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class AdminSellerApprovalController extends Controller
{
    // TAMPILKAN DAFTAR STORE UNTUK ADMIN
    public function listStores()
    {
        $stores = Store::with('user')->get();

        // jika sudah ada view pakai ini:
        // return view('admin.stores.index', compact('stores'));
        // jika belum ada view, ubah jadi:
        return response()->json($stores);
    }

    // SETUJUI SELLER
    public function approve($id)
    {
        $store = Store::findOrFail($id);

        // Validasi agar tidak approve ulang
        if ($store->is_verified) {
            return back()->with('error', 'Store sudah diverifikasi.');
        }

        $store->update([
            'is_verified' => true
        ]);

        return back()->with('success', 'Seller berhasil disetujui.');
    }

    // TOLAK SELLER
    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|min:5'
        ]);

        $store = Store::findOrFail($id);

        $store->update([
            'is_verified' => false
        ]);

        return back()->with('success', 'Seller ditolak.');
    }
}
