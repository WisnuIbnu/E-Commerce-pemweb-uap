<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerStoreController extends Controller
{
    /**
     * Menampilkan form edit profil toko.
     */
    public function edit()
    {
        $store = Auth::user()->store;
        return view('seller.store.edit', compact('store'));
    }

    /**
     * Memperbarui data toko.
     */
    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name'        => 'required|string|max:255|unique:stores,name,' . $store->id, // Ignore unique untuk diri sendiri
            'about'       => 'required|string',
            'phone'       => 'required|numeric',
            'address'     => 'required|string',
            'city'        => 'required|string',
            'postal_code' => 'required|string',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($request, $store) {
            $data = [
                'name'        => $request->name,
                'about'       => $request->about,
                'phone'       => $request->phone,
                'address'     => $request->address,
                'city'        => $request->city,
                'postal_code' => $request->postal_code,
            ];

            // Cek jika ada upload logo baru
            if ($request->hasFile('logo')) {
                // Hapus logo lama jika ada (dan bukan default)
                if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                    Storage::disk('public')->delete($store->logo);
                }
                
                // Simpan logo baru
                $data['logo'] = $request->file('logo')->store('store_logos', 'public');
            }

            $store->update($data);
        });

        return redirect()->back()->with('success', 'Profil toko berhasil diperbarui!');
    }

    /**
     * Menghapus toko (Danger Zone).
     */
    public function destroy()
    {
        $user = Auth::user();
        $store = $user->store;

        DB::transaction(function () use ($user, $store) {
            // 1. Hapus Logo dari storage
            if ($store->logo && Storage::disk('public')->exists($store->logo)) {
                Storage::disk('public')->delete($store->logo);
            }

            // 2. Hapus data Toko (Produk akan terhapus otomatis jika onCascadeDelete aktif di migration)
            $store->delete();

            // 3. Kembalikan Role user menjadi 'member'
            $user->role = 'member';
            $user->save();
        });

        return redirect()->route('dashboard')->with('success', 'Toko Anda telah dihapus. Anda kembali menjadi Member.');
    }
}