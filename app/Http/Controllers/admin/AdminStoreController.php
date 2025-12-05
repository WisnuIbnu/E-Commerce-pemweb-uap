<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;

class AdminStoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        return view('admin.stores.show', compact('store'));
    }

    public function verify(Store $store)
    {
        $store->update(['is_verified' => 1]);
        return back();
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index');
    }
}
