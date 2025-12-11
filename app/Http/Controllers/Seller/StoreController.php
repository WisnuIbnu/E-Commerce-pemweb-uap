<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    // Menampilkan halaman profil toko
    public function edit()
    {
        $store = auth()->user()->store;
        return view('seller.store.edit', compact('store'));
    }

    // Memperbarui profil toko
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'required|string',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);

        $store = auth()->user()->store;
        $store->update([
            'name' => $request->name,
            'about' => $request->about,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
        ]);

        return redirect()->route('seller.store.edit')->with('status', 'Profil toko berhasil diperbarui.');
    }
}
