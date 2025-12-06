<?php
// app/Http/Controllers/Admin/StoreVerificationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    public function index()
    {
        $pendingStores = Store::with('buyer')
            ->where('status', 'pending')
            ->latest()
            ->paginate(15);

        return view('admin.stores.pending', compact('pendingStores'));
    }

    public function show(Store $store)
    {
        $store->load('buyer');
        return view('admin.stores.verify', compact('store'));
    }

    public function approve(Store $store)
    {
        if ($store->status !== 'pending') {
            return back()->with('error', 'Store is not pending approval');
        }

        $store->update([
            'status' => 'approved',
            'rejection_reason' => null
        ]);

        // TODO: Send email notification to store owner

        return redirect()->route('admin.stores.pending')
            ->with('success', 'Store approved successfully!');
    }

    public function reject(Request $request, Store $store)
    {
        if ($store->status !== 'pending') {
            return back()->with('error', 'Store is not pending approval');
        }

        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $store->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason']
        ]);

        // TODO: Send email notification to store owner

        return redirect()->route('admin.stores.pending')
            ->with('success', 'Store rejected successfully!');
    }
}
