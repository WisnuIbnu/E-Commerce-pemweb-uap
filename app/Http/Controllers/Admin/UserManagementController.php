<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::all();
        $stores = Store::all();

        return view('admin.users.index', compact('users', 'stores'));
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}