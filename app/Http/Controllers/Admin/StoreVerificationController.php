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
        $pendingStores = Store::with('user')
            ->where('is_verified', false)
            ->latest()
            ->paginate(10);
        
        return view('admin.stores.verification', compact('pendingStores'));
    }
    
    public function verify($id)
    {
        $store = Store::findOrFail($id);
        $store->is_verified = true;
        $store->save();
        
        return back()->with('success', 'Store verified successfully!');
    }
    
    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();
        
        return back()->with('success', 'Store rejected and deleted!');
    }
}

