<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Store::with('user');

        if ($request->has('verified')) {
            if ($request->verified === 'verified') {
                $query->where('is_verified', true);
            } elseif ($request->verified === 'unverified') {
                $query->where('is_verified', false);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $stores = $query->latest()->paginate(15);

        return view('admin.stores.index', compact('stores'));
    }

    public function show($id)
    {
        $store = Store::with([
            'user',
            'products',
            'transactions',
            'balance'
        ])->findOrFail($id);

        $stats = [
            'total_products' => $store->products()->count(),
            'total_transactions' => $store->transactions()->count(),
            'total_revenue' => $store->transactions()
                ->where('payment_status', 'delivered')
                ->sum('grand_total'),
            'balance' => $store->balance->balance ?? 0,
        ];

        return view('admin.store.show', compact('store', 'stats'));
    }

    public function suspend($id)
    {
        $store = Store::findOrFail($id);
        
        $store->update(['is_verified' => false]);

        return back()->with('success', 'Store suspended successfully');
    }

    public function activate($id)
    {
        $store = Store::findOrFail($id);
        
        $store->update(['is_verified' => true]);

        return back()->with('success', 'Store activated successfully');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);

        $hasPendingOrders = $store->transactions()
            ->whereIn('payment_status', ['pending', 'processing', 'shipped'])
            ->exists();

        if ($hasPendingOrders) {
            return back()->with('error', 'Cannot delete store with pending orders');
        }

        foreach ($store->products as $product) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
                $image->delete();
            }
            $product->delete();
        }

        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->delete();

        $store->user->update(['role' => 'customer']);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully');
    }
}