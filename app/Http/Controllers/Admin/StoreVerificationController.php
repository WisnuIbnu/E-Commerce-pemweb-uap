<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    public function index()
    {
        $pendingStores = Store::with('user')
            ->where('is_verified', false)
            ->latest()
            ->paginate(10);

        return view('admin.store-verification.index', compact('pendingStores'));
    }

    public function show($id)
    {
        $store = Store::with('user')->findOrFail($id);
        return view('admin.store-verification.show', compact('store'));
    }

    public function verify($id)
    {
        $store = Store::findOrFail($id);
        
        $store->update(['is_verified' => true]);
        
        return redirect()->route('admin.store-verification.index')
            ->with('success', 'Store verified successfully');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $store = Store::findOrFail($id);
        
        
        $store->delete();

        return redirect()->route('admin.store-verification.index')
            ->with('success', 'Store rejected and deleted');
    }
}