<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreVerificationController extends Controller
{
    public function index()
    {
        $stores = Store::where('is_verified', false)->get();
        return view('admin.stores.index', compact('stores'));
    }

    public function verify($id)
    {
        $store = Store::findOrFail($id);
        $store->is_verified = true;
        $store->save();

        return back()->with('success', 'Store verified successfully.');
    }

    public function reject($id)
    {
        $store = Store::findOrFail($id);
        $store->is_verified = false;
        $store->save();

        return back()->with('success', 'Store rejected.');
    }
}