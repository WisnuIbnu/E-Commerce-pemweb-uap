<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function index()
    {
        // tampilkan semua store + pemilik
        $stores = Store::with('user')->latest()->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        // detail toko
        $store->load('user');
        return view('admin.stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        // halaman khusus ubah status
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $status = $request->status;

        $store->update([
            'status'      => $status,
            'is_verified' => $status === 'approved' ? 1 : 0,
        ]);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store status updated.');
    }

    // Tombol verifikasi cepat
    public function verify(Store $store)
    {
    $store->update([
        'status'      => 'approved',
        'is_verified' => 1,
    ]);

    return back()->with('success', 'Store verified.');
    }

    // Tombol tolak cepat
    public function reject(Store $store)
    {
        $store->update([
            'status'      => 'rejected',
            'is_verified' => 0,
        ]);

        return back()->with('success', 'Store rejected.');
    }


    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted.');
    }
}
