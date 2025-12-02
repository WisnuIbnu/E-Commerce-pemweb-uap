<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    public function dashboard()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $store = $user->store; // relasi user -> store

            // Jika belum punya store, arahkan ke create store
            if (!$store) {
                return redirect()->route('seller.store.create')
                                 ->with('warning', 'Silakan buat toko terlebih dahulu.');
            }

            // Jika toko belum diverifikasi, tetap di halaman create/edit store
            if (!$store->is_verified) {
                return redirect()->route('seller.store.create')
                                 ->with('warning', 'Toko Anda sedang menunggu verifikasi admin.');
            }

            $totalProducts = $store->products()->count();
            $totalOrders = $store->transactions()->count();
            $balance = $store->balance ? $store->balance->amount : 0;

            return view('seller.dashboard', compact('store', 'totalProducts', 'totalOrders', 'balance'));

        } catch (\Exception $e) {
            Log::error('Error Seller Dashboard: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memuat dashboard.');
        }
    }

    // Tampilkan form registrasi / create store
    public function create()
    {
        try {
            return view('seller.store.register');
        } catch (\Exception $e) {
            Log::error('Error Load Create Store: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuka form.');
        }
    }

    // Simpan data store baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $logoName = null;
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $logoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $stored = $file->storeAs('public/store_logos', $logoName);
                if (!$stored) {
                    return redirect()->back()->with('error', 'Gagal mengunggah logo.');
                }
            }

            $store = new Store();
            $store->user_id = $user->id;
            $store->name = $request->name;
            $store->about = $request->about;
            $store->phone = $request->phone;
            $store->address = $request->address;
            $store->city = $request->city;
            $store->postal_code = $request->postal_code;
            $store->logo = $logoName;
            $store->address_id = 'default';
            $store->is_verified = false;
            $store->save();

            return redirect()->route('seller.dashboard')
                             ->with('success', 'Toko berhasil dibuat. Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            Log::error('Error Store Creation: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat toko.');
        }
    }

    // Tampilkan form edit store
    public function edit()
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $store = $user->store;

            if (!$store) {
                return redirect()->route('seller.store.create');
            }

            return view('seller.store.edit', compact('store'));

        } catch (\Exception $e) {
            Log::error('Error Load Edit Store: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuka form edit toko.');
        }
    }

    // Update data store
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:20',
        ]);

        try {
            $user = Auth::user();
            if (!$user) {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
            }

            $store = $user->store;

            if (!$store) {
                return redirect()->route('seller.store.create');
            }

            $store->name = $request->name;
            $store->about = $request->about;
            $store->phone = $request->phone;
            $store->address = $request->address;
            $store->city = $request->city;
            $store->postal_code = $request->postal_code;
            $store->save();

            return redirect()->route('seller.store.edit')
                             ->with('success', 'Profil toko berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Error Update Store: '.$e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui toko.');
        }
    }
}
