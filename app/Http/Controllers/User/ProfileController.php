<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profile.
     */
    public function edit(Request $request)
    {
        $user = $request->user(); // user yang login

        return view('user.profile.profile-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update profile (nama).
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user->name = $request->name;
        $user->save();

        return back()->with('status', 'profile-updated');
    }

    /**
     * Daftar jadi seller (ubah role di table users).
     */
    public function becomeSeller(Request $request)
    {
    $user = $request->user();

    // Validasi input dari form
    $request->validate([
        'store_name' => 'required|string|max:255',
        'store_about' => 'required|string',
        'store_phone' => 'required|string',
        'store_address' => 'required|string',
        'store_city' => 'required|string',
        'store_postcode' => 'required|string',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Logo optional, hanya image
    ]);

    // Simpan data toko di tabel stores
    $store = new Store([
        'name' => $request->store_name,
        'about' => $request->store_about,
        'phone' => $request->store_phone,
        'address' => $request->store_address,
        'city' => $request->store_city,
        'postal_code' => $request->store_postcode,
        'is_verified' => false,  // Status seller saat mendaftar belum terverifikasi
    ]);

    // Menyimpan data toko dan mengaitkannya dengan user
    $user->store()->save($store);

    // Mengubah role user menjadi seller
    $user->role = 'seller';
    $user->save();

    return back()->with('status', 'Kamu sekarang terdaftar sebagai seller!');
    }

    /**
     * Hapus akun (opsional).
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        // Validasi password sebelum delete
        $request->validate([
            'password' => ['required'],
        ]);

        if (! Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah.']);
        }

        Auth::logout();

        $user->delete();

        return redirect('/')->with('status', 'Akun berhasil dihapus.');
    }
}
