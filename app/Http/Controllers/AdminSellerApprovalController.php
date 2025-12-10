<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminSellerApprovalController extends Controller
{
    // TAMPILKAN DAFTAR STORE UNTUK ADMIN
    public function listStores()
    {
        $stores = Store::with('user')->get();

        return view('admin.stores.index', compact('stores'));
    }

    // SETUJUI SELLER
    public function approve($id)
    {
        $store = Store::findOrFail($id);

        if ($store->status === 'approved') {
            return back()->with('error', 'Store sudah disetujui sebelumnya.');
        }

        $store->update([
            'is_verified' => true,
            'status'      => 'approved',
            'reason'      => null,
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
            'is_verified' => false,
            'status'      => 'rejected',
            'reason'      => $request->reason
        ]);

        return back()->with('success', 'Seller berhasil ditolak.');
    }
}
