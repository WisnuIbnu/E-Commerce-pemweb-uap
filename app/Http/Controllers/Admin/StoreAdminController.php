<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class StoreAdminController extends Controller
{
    // GET /admin/store-verification
    public function index()
    {
    $stores = Store::where('status', 'pending')
        ->whereNotNull('owner_id')   // ← tambahkan baris ini
        ->with('owner')
        ->latest()
        ->get();

    return view('admin.store-verification', compact('stores'));
    }


    // POST /admin/store-verification/{id}/approve
    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['status' => 'active']);

        return back()->with('success', 'Toko berhasil disetujui.');
    }

    // POST /admin/store-verification/{id}/reject
    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->update(['status' => 'rejected']);

        return back()->with('success', 'Toko ditolak.');
    }
}
