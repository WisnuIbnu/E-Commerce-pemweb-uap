<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuyerProfileController extends Controller
{
    /**
     * Tampilkan form untuk membuat / melengkapi profil buyer.
     */
    public function create()
    {
        $user = Auth::user();

        // Kalau sudah punya buyer, langsung arahkan ke dashboard / halaman lain
        if ($user->buyer) {
            return redirect()
                ->route('dashboard')
                ->with('info', 'Profil pembeli Anda sudah lengkap.');
        }

        return view('buyer_profile_create', compact('user'));
    }

    /**
     * Simpan profil buyer baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Kalau sudah punya buyer, tidak perlu buat lagi
        if ($user->buyer) {
            return redirect()
                ->route('dashboard')
                ->with('info', 'Profil pembeli Anda sudah ada.');
        }

        $validated = $request->validate([
            'phone_number'     => ['required', 'string', 'max:255'],
            'profile_picture'  => ['nullable', 'image', 'max:2048'],
        ]);

        $profilePicturePath = null;

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('buyers', 'public');
        }

        Buyer::create([
            'user_id'         => $user->id,
            'phone_number'    => $validated['phone_number'],
            'profile_picture' => $profilePicturePath,
        ]);

        return redirect()
            ->route('dashboard') // atau langsung ke transactions.index / checkout, terserah flow kamu
            ->with('success', 'Profil pembeli berhasil dibuat.');
    }
}
