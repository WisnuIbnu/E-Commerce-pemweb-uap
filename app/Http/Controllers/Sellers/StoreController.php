<?php

namespace App\Http\Controllers\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {
        $store = Store::where('user_id', auth()->id())->first();
        return view('seller.store.index', compact('store'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string',
            'logo'          => 'nullable|image|max:2048',
            'about'         => 'required|string',
            'phone'         => 'required|string',
            'address_id'    => 'required|string',
            'city'          => 'required|string',
            'address'       => 'required|string',
            'postal_code'   => 'required|string',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store_logos', 'public');
        }

        Store::create([
            'user_id'       => auth()->id(),
            'name'          => $request->name,
            'logo'          => $logoPath,
            'about'         => $request->about,
            'phone'         => $request->phone,
            'address_id'    => $request->address_id,
            'city'          => $request->city,
            'address'       => $request->address,
            'postal_code'   => $request->postal_code,
            'is_verified'   => false,
        ]);

        return redirect()->route('seller.store')->with('success', 'Store created successfully');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string',
            'logo'          => 'nullable|image|max:2048',
            'about'         => 'required|string',
            'phone'         => 'required|string',
            'address_id'    => 'required|string',
            'city'          => 'required|string',
            'address'       => 'required|string',
            'postal_code'   => 'required|string',
        ]);

        $store = Store::findOrFail($id);

        $logoPath = $store->logo;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store_logos', 'public');
        }

        $store->update([
            'name'          => $request->name,
            'logo'          => $logoPath,
            'about'         => $request->about,
            'phone'         => $request->phone,
            'address_id'    => $request->address_id,
            'city'          => $request->city,
            'address'       => $request->address,
            'postal_code'   => $request->postal_code,
        ]);

        return redirect()->route('seller.store')->with('success', 'Store updated successfully');
    }

    public function destroy($id)
    {
        $store = Store::findOrFail($id);
        $store->delete();

        return redirect()->route('seller.store')->with('success', 'Store deleted');
    }
}