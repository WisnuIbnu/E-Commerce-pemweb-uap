<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function index()
    {
        $verifiedStores = Store::where('status', 'verified')->get();
        $pendingStores  = Store::where('status', 'pending')->get();

        return view('admin.stores.index', compact('verifiedStores', 'pendingStores'));
    }

    public function approve($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'verified';
        $store->save();

        return back()->with('success', 'Store berhasil diverifikasi.');
    }

    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->status = 'rejected';
        $store->save();

        return back()->with('success', 'Store ditolak.');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return back()->with('success', 'Store berhasil dihapus.');
    }
}
