<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    /**
     * Tampilkan daftar toko untuk verifikasi
     */
    public function index()
    {
        // Ambil semua toko dengan info user pemiliknya
        $stores = Store::with('user')
            ->withCount('products') // Hitung jumlah produk
            ->latest()
            ->paginate(10);

        return view('admin.store-verification', compact('stores'));
    }

    public function verify(Request $request, Store $store)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
        ]);

        if ($request->action === 'approve') {
            $store->update(['is_verified' => true]);
            $message = 'Toko berhasil diverifikasi!';
        } else {
            $store->update(['is_verified' => false]);
            $message = 'Toko ditolak/unverified!';
        }

        return back()->with('success', $message);
    }

    public function show(Store $store)
    {
        $store->load(['user', 'products.productImages', 'storeBallance']);
        
        return view('admin.store-detail', compact('store'));
    }

    public function destroy(Store $store)
    {
        $store->products()->delete();
        $store->delete();

        return redirect()->route('admin.store-verification')
            ->with('success', 'Toko berhasil dihapus!');
    }
}