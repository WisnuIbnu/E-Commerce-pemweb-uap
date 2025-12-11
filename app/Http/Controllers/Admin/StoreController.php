<?php
// app/Http/Controllers/Admin/StoreController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display a listing of stores
     */
    public function index(Request $request)
    {
        $query = Store::with(['user', 'products']);

        // Filter by verification status
        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->status === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        // Search by store name or owner
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Get stores with product count
        $stores = $query->withCount('products')
                       ->latest()
                       ->paginate(15);

        // Calculate statistics
        $stats = [
            'total' => Store::count(),
            'verified' => Store::where('is_verified', true)->count(),
            'unverified' => Store::where('is_verified', false)->count(),
            'total_products' => \App\Models\Product::count(),
        ];

        return view('admin.stores.index', compact('stores', 'stats'));
    }

    /**
     * Get users for store owner selection
     */
    public function create()
    {
        // Get users who don't have a store yet, or are sellers
        $users = User::where(function($query) {
            $query->where('role', 'seller')
                  ->orWhereDoesntHave('store');
        })->get(['id', 'name', 'email']);
        
        return response()->json(['users' => $users]);
    }

    /**
     * Store a newly created store
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'is_verified' => 'nullable|boolean',
        ]);

        // Check if user already has a store
        if (Store::where('user_id', $validated['user_id'])->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'This user already has a store'
            ], 422);
        }

        // Set is_verified (default false if not provided)
        $validated['is_verified'] = $request->has('is_verified') ? true : false;

        // Create store
        $store = Store::create($validated);

        // Update user role to seller if not already
        $user = User::find($validated['user_id']);
        if ($user->role !== 'seller' && $user->role !== 'admin') {
            $user->update(['role' => 'seller']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Store created successfully',
            'store' => $store
        ]);
    }

    /**
     * Get store data for editing
     */
    public function edit($id)
    {
        $store = Store::with('user')->findOrFail($id);
        
        return response()->json($store);
    }

    /**
     * Update the specified store
     */
    public function update(Request $request, $id)
    {
        $store = Store::findOrFail($id);

        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'about' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string',
            'postal_code' => 'nullable|string|max:10',
            'is_verified' => 'nullable|boolean',
        ]);

        // Set is_verified
        $validated['is_verified'] = $request->has('is_verified') ? true : false;

        // Update store
        $store->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Store updated successfully'
        ]);
    }

    /**
     * Remove the specified store
     */
    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        
        // Delete store logo if exists
        if ($store->logo && Storage::disk('public')->exists($store->logo)) {
            Storage::disk('public')->delete($store->logo);
        }

        // Delete all products and their images
        foreach ($store->products as $product) {
            // Delete product image if exists
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            
            // Delete product
            $product->delete();
        }

        // Delete store balance if exists
        if ($store->storeBallance) {
            $store->storeBallance->delete();
        }

        // Delete store
        $store->delete();

        return response()->json([
            'success' => true,
            'message' => 'Store and all its products deleted successfully'
        ]);
    }

    /**
     * Toggle store verification status
     */
    public function toggleVerification($id)
    {
        $store = Store::findOrFail($id);
        
        // Toggle verification
        $store->is_verified = !$store->is_verified;
        $store->save();

        $status = $store->is_verified ? 'verified' : 'unverified';

        return response()->json([
            'success' => true,
            'message' => "Store {$status} successfully",
            'is_verified' => $store->is_verified
        ]);
    }
}