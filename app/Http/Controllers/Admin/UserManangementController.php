<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;

class UserManagementController extends Controller
{
    public function users()
    {
        $users = User::withCount(['buyer', 'store'])
            ->latest()
            ->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function stores()
    {
        $stores = Store::with('user')
            ->withCount('products')
            ->latest()
            ->paginate(15);
        
        return view('admin.stores.index', compact('stores'));
    }
    
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin user');
        }
        
        $user->delete();
        
        return back()->with('success', 'User deleted successfully!');
    }
    
    public function deleteStore($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        
        return back()->with('success', 'Store deleted successfully!');
    }
}