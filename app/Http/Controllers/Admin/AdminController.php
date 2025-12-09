<?php

namespace App\Http\Controllers\Admin;

use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Menampilkan halaman Dashboard Admin
    public function dashboard()
    {
        // Ambil data store yang belum diverifikasi
        $stores = Store::where('is_verified', false)->get();
        // ambil user dari database
        $users = User::all();

        // Kirimkan data $stores ke view admin.dashboard
        return view('admin.dashboard', compact('stores', 'users'));
    }

    // Menampilkan halaman verifikasi toko
    public function storeVerification()
    {
        $stores = Store::where('is_verified', false)->get(); // Menampilkan toko yang belum diverifikasi
        return view('admin.store-verification', compact('stores'));
    }

    // Verifikasi toko
    public function verifyStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->is_verified = true;
        $store->save();

        return back()->with('status', 'Store Verified');
    }

    // Tolak toko
    public function rejectStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->is_verified = false;
        $store->save();

        return back()->with('status', 'Store Rejected');
    }

    // Menampilkan semua user dan store
    public function manageUsersAndStores()
    {
        $users = User::all();
        $stores = Store::all();
        return view('admin.user-store-management', compact('users', 'stores'));
    }

    // Hapus user
    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return back()->with('status', 'User Deleted');
    }

    // Hapus store
    public function deleteStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->delete();
        return back()->with('status', 'Store Deleted');
    }
}
