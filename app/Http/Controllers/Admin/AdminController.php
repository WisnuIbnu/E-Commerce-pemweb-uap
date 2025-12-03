<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard Admin - Tampilkan statistik
     */
    public function dashboard()
    {
        // Hitung data statistik
        $totalUsers = User::count();
        $totalStores = Store::count();
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        
        $pendingStores = Store::where('is_verified', false)->count();
        $verifiedStores = Store::where('is_verified', true)->count();
        
        $adminCount = User::where('role', 'admin')->count();
        $memberCount = User::where('role', 'member')->count();

        // Toko pending (butuh verifikasi)
        $pendingStoresList = Store::with('user')
            ->where('is_verified', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalStores', 
            'totalProducts',
            'totalTransactions',
            'pendingStores',
            'verifiedStores',
            'adminCount',
            'memberCount',
            'pendingStoresList'
        ));
    }

    /**
     * Kelola Users - Tampilkan semua user
     */
    public function manageUsers()
    {
        $users = User::with('store')
            ->latest()
            ->paginate(20);

        return view('admin.manage-users', compact('users'));
    }

    /**
     * Update role user
     */
    public function updateUserRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,member',
        ]);

        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role user berhasil diubah!');
    }

    /**
     * Hapus user
     */
    public function deleteUser(User $user)
    {
        // Jangan bisa hapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }

        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}
