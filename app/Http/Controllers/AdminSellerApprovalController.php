<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\User;

class AdminSellerApprovalController extends Controller
{
    public function listStores()
    {
        $stores = Store::with('user')->latest()->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }

    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'approved';
        $store->save();

        $store->user->update(['role' => 'seller']);

        return back()->with('success', 'Store berhasil disetujui!');
    }

    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'rejected';
        $store->save();

        return back()->with('success', 'Store berhasil ditolak.');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('admin.stores.index')
                        ->with('success', 'Toko berhasil dihapus');
    }

}
