<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StoreRegistrationController extends Controller
{
    /**
     * Tampilkan form registrasi toko
     */
    public function create()
    {
        if (Store::hasStore(Auth::id())) {
            return redirect()->route('store.dashboard')
                ->with('info', 'Anda sudah memiliki toko.');
        }

        return view('store.register');
    }

    /**
     * Tampilkan halaman pending verification
     */
    public function pending()
    {
        $store = Store::where('user_id', Auth::id())->first();
        
        if (!$store) {
            return redirect()->route('store.register')
                ->with('info', 'Anda belum mendaftar sebagai seller.');
        }
        
        if ($store->is_verified) {
            return redirect()->route('store.dashboard');
        }
        
        return view('store.pending', compact('store'));
    }

    /**
     * Proses registrasi toko baru
     */
    public function store(Request $request)
    {
        if (Store::hasStore(Auth::id())) {
            return redirect()->route('store.dashboard')
                ->with('error', 'Anda sudah memiliki toko.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'about' => 'required|string|min:50',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ], [
            'name.required' => 'Nama toko harus diisi.',
            'name.unique' => 'Nama toko sudah digunakan.',
            'about.required' => 'Deskripsi toko harus diisi.',
            'about.min' => 'Deskripsi toko minimal 50 karakter.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'city.required' => 'Kota harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'postal_code.required' => 'Kode pos harus diisi.',
        ]);

        DB::beginTransaction();
        
        try {
            $logoPath = null;
            if ($request->hasFile('logo')) {
                $logo = $request->file('logo');
                $logoName = time() . '_' . uniqid() . '.' . $logo->getClientOriginalExtension();
                $logo->move(public_path('images/stores'), $logoName);
                $logoPath = 'images/stores/' . $logoName;
            }
            $store = Store::create([
                'user_id' => Auth::id(),
                'name' => $validated['name'],
                'logo' => $logoPath,
                'about' => $validated['about'],
                'phone' => $validated['phone'],
                'city' => $validated['city'],
                'address' => $validated['address'],
                'postal_code' => $validated['postal_code'],
                'is_verified' => false,
            ]);

            StoreBalance::create([
                'store_id' => $store->id,
                'balance' => 0,
            ]);

            DB::commit();

            return redirect()->route('store.dashboard')
                ->with('success', 'Toko berhasil didaftarkan! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($logoPath && file_exists(public_path($logoPath))) {
                unlink(public_path($logoPath));
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard toko seller
     */
    public function dashboard()
    {
        $store = Store::where('user_id', Auth::id())->first();

        if (!$store) {
            return redirect()->route('store.register')
                ->with('info', 'Anda belum memiliki toko. Daftar sekarang!');
        }

        $store->load(['products', 'balance']);

        $stats = [
            'total_products' => $store->products()->count(),
            'active_products' => $store->products()->where('stock', '>', 0)->count(),
            'total_revenue' => $store->balance->balance ?? 0,
            'pending_orders' => 0, 
        ];

        return view('store.dashboard', compact('store', 'stats'));
    }
}