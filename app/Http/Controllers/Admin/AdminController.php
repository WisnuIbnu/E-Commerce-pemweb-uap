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
        // Ambil data store yang sudah diverifikasi
        $storesVerified = Store::where('is_verified', true)->get();
        // Ambil data store yang belum diverifikasi
        $storesUnverified = Store::where('is_verified', false)->get();
        // Ambil data user
        $users = User::all();

        // Kirimkan data $storesVerified dan $storesUnverified ke view admin.dashboard
        return view('admin.dashboard', compact('storesVerified', 'storesUnverified', 'users'));
    }

    public function storeVerification()
    {
        // Ambil data toko yang belum diverifikasi
        $stores = Store::where('is_verified', false)->get();
        return view('admin.store-verification', compact('stores'));
    }

    public function verifyStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->update(['is_verified' => true]);
        return redirect()->back()->with('success', 'Store verified successfully.');
    }

    public function rejectStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->delete();
        return redirect()->back()->with('success', 'Store rejected and deleted.');
    }

    public function manageUsersAndStores()
    {
        $users = User::all();
        $stores = Store::all();
        return view('admin.users-and-stores', compact('users', 'stores'));
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

    public function deleteStore($storeId)
    {
        $store = Store::findOrFail($storeId);
        $store->delete();
        return redirect()->back()->with('success', 'Store deleted successfully.');
    }
}
