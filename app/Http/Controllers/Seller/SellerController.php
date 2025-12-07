<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    /**
     * Tampilkan form pendaftaran toko.
     */
    public function create()
{
    // kalau seller sudah punya toko, langsung lempar ke dashboard
    $store = Store::where('user_id', Auth::id())->first();
    if ($store) {
        return redirect()->route('seller.dashboard');
    }

    return view('seller.form');
}

    /**
     * Simpan data pendaftaran toko.
     */
public function store(Request $request)
{
    // 1. VALIDASI INPUT
    $request->validate([
        'name'        => ['required', 'string', 'max:255'],
        'logo'        => ['nullable'],           // logo bener-bener opsional
        'about'       => ['nullable', 'string'],
        'phone'       => ['required', 'string', 'max:20'],
        'city'        => ['required', 'string', 'max:100'],
        'address'     => ['required', 'string'],
        'postal_code' => ['required', 'string', 'max:10'],
    ]);

    // 2. UPLOAD LOGO (JIKA ADA & VALID)
    //    PENTING: default BUKAN null supaya MySQL nggak marah
    $logoPath = '';  // ← ini WAJIB ada

    if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
        $logoPath = $request->file('logo')->store('store_logos', 'public');
    }

    // 3. SIAPKAN DATA INSERT
    $data = [
        'user_id'     => Auth::id(),
        'name'        => $request->name,
        'logo'        => $logoPath,      // ← SELALU string, nggak pernah null
        'about'       => $request->about,
        'phone'       => $request->phone,
        'address_id'  => 0,              // default aja dulu
        'city'        => $request->city,
        'address'     => $request->address,
        'postal_code' => $request->postal_code,
        'is_verified' => 0,
        'status'      => 'pending',
    ];

    // 4. INSERT KE DATABASE
    Store::create($data);

    // 5. REDIRECT KE DASHBOARD SELLER
    return redirect()
        ->route('seller.dashboard')
        ->with('success', 'Toko berhasil dibuat dan sedang menunggu verifikasi admin.');
}

    /**
     * Dashboard seller.
     */
    public function dashboard()
    {
        $store = Store::where('user_id', Auth::id())->first();

        return view('seller.dashboard', compact('store'));
    }
}
