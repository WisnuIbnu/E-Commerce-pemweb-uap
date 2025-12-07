<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display list of all users
     */
    public function index(Request $request)
    {
        $query = User::with(['store', 'buyer']);

        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        // Statistics
        $totalUsers = User::count();
        $adminCount = User::where('role', 'admin')->count();
        $memberCount = User::where('role', 'member')->count();
        $sellerCount = User::whereHas('store')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'adminCount',
            'memberCount',
            'sellerCount'
        ));
    }

    /**
     * Display user detail
     */
    public function show(User $user)
    {
        $user->load(['store', 'buyer.transactions']);

        // Get user statistics
        $totalPurchases = 0;
        $totalSpent = 0;

        if ($user->buyer) {
            $totalPurchases = $user->buyer->transactions()->count();
            $totalSpent = $user->buyer->transactions()
                ->where('payment_status', 'paid')
                ->sum('grand_total');
        }

        $storeRevenue = 0;
        if ($user->store) {
            $storeRevenue = $user->store->transactions()
                ->where('payment_status', 'paid')
                ->sum('grand_total');
        }

        return view('admin.users.show', compact(
            'user',
            'totalPurchases',
            'totalSpent',
            'storeRevenue'
        ));
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,member',
        ]);

        // Prevent self-demotion
        if ($user->id === auth()->id() && $validated['role'] !== 'admin') {
            return back()->with('error', 'You cannot change your own role');
        }

        $user->update(['role' => $validated['role']]);

        return back()->with('success', 'User role updated successfully!');
    }

    /**
     * Delete user
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        // Don't allow deleting admin
        if ($user->role === 'admin') {
            return back()->with('error', 'Cannot delete admin user');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Ban/Suspend user
     */
    public function ban(User $user)
    {
        // You can add a 'banned' column to users table
        // For now, we'll just prevent login by setting a flag

        return back()->with('info', 'Ban feature coming soon');
    }
}