<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::latest()->paginate(10);
        return view('admin.stores.index', compact('stores'));
    }
    public function approve(Store $store)
{
    $store->is_verified = 1;
    $store->save();

    return redirect()->route('admin.stores.index')->with('success', 'Toko berhasil disetujui.');
}




    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
        ]);

        Store::create([
            'store_name' => $request->store_name,
            'owner' => $request->owner,
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Store berhasil dibuat.');
    }

    public function show(Store $store)
    {
        return view('admin.stores.show', compact('store'));
    }

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'owner' => 'required|string|max:255',
        ]);

        $store->update([
            'store_name' => $request->store_name,
            'owner' => $request->owner,
        ]);

        return redirect()->route('admin.stores.index')->with('success', 'Store berhasil diperbarui.');
    }

    public function destroy(Store $store)
    {
        $store->delete();
        return redirect()->route('admin.stores.index')->with('success', 'Store berhasil dihapus.');
    }
}
