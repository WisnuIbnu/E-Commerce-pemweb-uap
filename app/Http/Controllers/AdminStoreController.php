<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreController extends Controller
{
    public function index()
    {
        $stores = Store::orderBy('created_at', 'desc')->get();

        return view('admin.stores.index', compact('stores'));
    }

    public function approve(Store $store)
    {
        $store->update([
            'status' => 'approved'
        ]);

        return back()->with('success', 'Store approved.');
    }

    public function reject(Store $store)
    {
        $store->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Store rejected.');
    }
    
    public function updateStatus(Request $request, Store $store)
    {
        $request->validate(['status' => 'required|string']);
        $store->status = $request->status;
        $store->save();
    
        return back()->with('success', 'Store status updated.');
    }
}
