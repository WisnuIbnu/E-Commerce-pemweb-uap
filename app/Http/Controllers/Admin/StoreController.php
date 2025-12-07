<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Display list of all stores
     */
    public function index(Request $request)
    {
        $query = Store::with('user');

        // Filter by verification status
        if ($request->filled('status')) {
            if ($request->status === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->status === 'pending') {
                $query->where('is_verified', false);
            }
        }

        // Search by store name or owner name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $stores = $query->latest()->paginate(15);

        // Statistics
        $totalStores = Store::count();
        $verifiedStores = Store::where('is_verified', true)->count();
        $pendingStores = Store::where('is_verified', false)->count();

        return view('admin.stores.index', compact(
            'stores',
            'totalStores',
            'verifiedStores',
            'pendingStores'
        ));
    }

    /**
     * Display store detail for verification
     */
    public function show(Store $store)
    {
        $store->load(['user', 'products']);

        // Get store statistics
        $totalProducts = $store->products()->count();
        $totalOrders = $store->transactions()->count();
        $totalRevenue = $store->transactions()
            ->where('payment_status', 'paid')
            ->sum('grand_total');

        return view('admin.stores.show', compact(
            'store',
            'totalProducts',
            'totalOrders',
            'totalRevenue'
        ));
    }

    /**
     * Verify store
     */
    public function verify(Store $store)
    {
        if ($store->is_verified) {
            return back()->with('info', 'Store is already verified');
        }

        $store->update(['is_verified' => true]);

        // You can send notification email to store owner here
        // Mail::to($store->user->email)->send(new StoreVerified($store));

        return back()->with('success', 'Store verified successfully!');
    }

    /**
     * Reject/Unverify store
     */
    public function reject(Store $store)
    {
        if (!$store->is_verified) {
            return back()->with('info', 'Store is not verified yet');
        }

        $store->update(['is_verified' => false]);

        // You can send notification email to store owner here
        // Mail::to($store->user->email)->send(new StoreRejected($store));

        return back()->with('success', 'Store verification revoked');
    }

    /**
     * Delete store
     */
    public function destroy(Store $store)
    {
        // Delete store logo
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        // Delete all product images
        foreach ($store->products as $product) {
            foreach ($product->productImages as $image) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully!');
    }
}