<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get users with pagination
        $users = $query->latest()->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => User::count(),
            'admin' => User::where('role', 'admin')->count(),
            'seller' => User::whereHas('store')->count(),
            'member' => User::where(function($q) {
                $q->where('role', 'member')
                  ->orWhereNull('role');
            })->count(),
        ];

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,seller,member',
        ]);

        // Hash password
        $validated['password'] = Hash::make($validated['password']);

        // Create user
        $user = User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    /**
     * Get user data for editing
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        
        return response()->json($user);
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required', 
                'string', 
                'email', 
                'max:255', 
                Rule::unique('users')->ignore($user->id)
            ],
            'role' => 'required|in:admin,seller,member',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'string|min:8'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        // Update user
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully'
        ]);
    }

    /**
     * Remove the specified user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You cannot delete your own account'
            ], 403);
        }

        // Delete user's store if exists
        if ($user->store) {
            // Delete all products in the store
            foreach ($user->store->products as $product) {
                // Delete product image if exists
                if ($product->image && \Storage::disk('public')->exists($product->image)) {
                    \Storage::disk('public')->delete($product->image);
                }
                $product->delete();
            }
            
            // Delete store logo if exists
            if ($user->store->logo && \Storage::disk('public')->exists($user->store->logo)) {
                \Storage::disk('public')->delete($user->store->logo);
            }
            
            $user->store->delete();
        }

        // Delete user's buyer profile if exists
        if ($user->buyer) {
            $user->buyer->delete();
        }

        // Delete user
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
}