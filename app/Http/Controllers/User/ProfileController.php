<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

        // kalau belum seller → ubah role
        if ($user->role !== 'seller') {
            $user->role = 'seller';
            $user->save();
        }

        return back()->with('status', 'Kamu sekarang seller!');
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
