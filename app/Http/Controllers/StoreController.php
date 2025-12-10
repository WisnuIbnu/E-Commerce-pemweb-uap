<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Menampilkan formulir pendaftaran toko.
     */
    public function create()
    {
        // Cek jika user sudah punya toko, redirect ke dashboard
        // Gunakan pengecekan role atau relasi store
        $existingStore = Store::where('user_id', Auth::id())->first();
        if ($existingStore) {
            return redirect()->route('dashboard'); 
        }

        return view('front.stores.create');
    }

    /**
     * Menyimpan data toko baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name'          => 'required|string|max:255|unique:stores,name',
            'logo'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'about'         => 'required|string',
            'phone'         => 'required|string|max:20',
            'city'          => 'required|string',
            'postal_code'   => 'required|string|max:10',
            'address'       => 'required|string',
            'address_id'    => 'required|string', // Pastikan input ini ada di form atau di-hidden
        ]);

        // Gunakan Transaction agar data Store, Saldo, dan Role User tersimpan bersamaan
        DB::transaction(function () use ($request) {
            
            // 2. Upload Logo
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logoPath = $request->file('logo')->store('store_logos', 'public');
            }

            // 3. Simpan Data Store ke Database
            $store = Store::create([
                'user_id'     => Auth::id(),
                'name'        => $request->name,
                'logo'        => $logoPath,
                'about'       => $request->about,
                'phone'       => $request->phone,
                'address_id'  => $request->address_id,
                'city'        => $request->city,
                'address'     => $request->address,
                'postal_code' => $request->postal_code,
                'is_verified' => false, 
            ]);

            // 4. Inisialisasi Saldo Toko
            StoreBalance::create([
                'store_id' => $store->id,
                'balance'  => 0,
            ]);

            // 5. UPDATE ROLE USER MENJADI SELLER
            $user = Auth::user();
            $user->role = 'seller';
            $user->save();
        });

        return redirect()->route('dashboard')->with('success', 'Selamat! Toko berhasil dibuat. Anda sekarang adalah Penjual.');
    }
}