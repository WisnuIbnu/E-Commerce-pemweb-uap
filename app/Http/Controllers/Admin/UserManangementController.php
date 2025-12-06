<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        $user->load(['buyer', 'transactions', 'reviews']);
        
        return view('admin.users.show', compact('user'));
    }
    
    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,buyer,seller',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully');
    }
    
    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'You cannot delete your own account');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully');
    }
}

