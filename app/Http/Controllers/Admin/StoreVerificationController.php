<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user')->withCount('products');

        // Filter by status
        if ($request->status === 'pending') {
            $query->where('is_verified', false);
        } elseif ($request->status === 'approved') {
            $query->where('is_verified', true);
        }

        // Search
        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $stores = $query->latest()->get();

        // Calculate stats
        $stats = [
            'pending' => Store::where('is_verified', false)->count(),
            'approved' => Store::where('is_verified', true)->count(),
            'rejected' => 0, // karena tidak ada kolom 'status' atau 'rejected'
        ];

        return view('admin.store-verification', compact('stores', 'stats'));
    }

    public function approve($id)
    {
        $store = Store::findOrFail($id);

        $store->update([
            'is_verified' => true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store approved successfully'
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|min:10'
        ]);

        $store = Store::findOrFail($id);

        // Simpan info reject di kolom tambahan (jika mau dibuat)
        $store->update([
            'is_verified' => false,
            // 'rejection_reason' => $request->reason, // optional jika ada kolom baru
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Store rejected successfully'
        ]);
    }

    public function show($id)
    {
        $store = Store::with(['user', 'products'])->findOrFail($id);
        return view('admin.store-detail', compact('store'));
    }
}
