<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function profile()
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $store
        ]);
    }

    public function update(Request $request)
    {
        $store = Store::where('user_id', Auth::id())->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'address_id' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'address' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        if ($request->hasFile('logo')) {
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }

            $store->logo = $request->file('logo')->store('stores', 'public');
        }

        $store->update([
            'name' => $request->name,
            'about' => $request->about,
            'phone' => $request->phone,
            'address_id' => $request->address_id,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil toko berhasil diperbarui',
            'data' => $store
        ]);
    }
}
