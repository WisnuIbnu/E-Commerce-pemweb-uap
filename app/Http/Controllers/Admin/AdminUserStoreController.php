<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserStoreController extends Controller
{
    // GET /admin/user-store-management
    public function index()
    {
        // Ambil semua user + relasi store
        $users = User::with('store')->get();

        return view('admin.user-store-management', compact('users'));
    }

    // GET /admin/user-management/{id}/edit
    public function edit($id)
    {
        $user = User::with('store')->findOrFail($id);

        return view('admin.user-edit', compact('user'));
    }

    public function update($id)
    {
    
    $user = User::with('store')->findOrFail($id);

    $data = request()->validate([
        'name'  => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'role'  => 'required|in:admin,member,seller',
    ]);

    $user->update($data);

    return redirect()
        ->route('admin.management')
        ->with('success', 'Data user berhasil diperbarui.');
    }

}
