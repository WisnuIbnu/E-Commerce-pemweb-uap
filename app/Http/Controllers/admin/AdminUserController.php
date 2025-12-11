<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // ============================
    // 1. Tampilkan daftar user
    // ============================
    public function index()
    {
        $users = User::with('store')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    // ============================
    // 2. Halaman edit role user
    // ============================
    public function edit(User $user)
    {
        $user->load('store'); // biar kalau seller, data toko ikut tampil
        return view('admin.users.edit', compact('user'));
    }

    // ============================
    // 3. Update role user
    // ============================
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:buyer,seller,admin',
        ]);

        // ❌ RULE 1: Seller tidak boleh diubah menjadi admin
        if ($user->role === 'seller' && $request->role === 'admin') {
            return back()
                ->withErrors(['role' => 'Seller tidak boleh diubah menjadi admin.'])
                ->withInput();
        }

        // ❌ RULE 2: Admin tidak boleh punya toko
        // Jadi kalau target role = admin tapi user ini masih punya toko, tolak
        if ($request->role === 'admin' && $user->store) {
            return back()
                ->withErrors(['role' => 'Admin tidak boleh memiliki toko. Hapus / nonaktifkan toko user ini terlebih dahulu.'])
                ->withInput();
        }

        // Kalau lolos aturan di atas, baru update role
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User role updated successfully.');
    }

    // ============================
    // 4. Hapus user
    // ============================
    public function destroy(User $user)
    {
        // Jika user punya store → hapus tokonya
        if ($user->store) {
            $user->store->delete();
        }

        // Hapus user
        $user->delete();

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
