<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        return view('seller.store.index', compact('store'));
    }

    public function create()
    {
        if (Auth::user()->store) {
            return redirect()->route('seller.store')->with('error', 'You already have a store.');
        }

        return view('seller.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'image|max:2048',
            'about' => 'required',
            'phone' => 'required',
            'address_id' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required'
        ]);

        $logoName = null;
        if ($request->has('logo')) {
            $logoName = time() . '-' . $request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/stores'), $logoName);
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'logo' => $logoName,
            'about' => $request->about,
            'phone' => $request->phone,
            'address_id' => $request->address_id,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'is_verified' => false,
        ]);

        return redirect()->route('seller.store')->with('success', 'Store created! Waiting for admin verification.');
    }

    public function edit()
    {
        $store = Auth::user()->store;
        return view('seller.store.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name' => 'required',
            'about' => 'required',
            'phone' => 'required',
            'address_id' => 'required',
            'city' => 'required',
            'address' => 'required',
            'postal_code' => 'required'
        ]);

        if ($request->has('logo')) {
            $fileName = time() . '-' . $request->logo->getClientOriginalName();
            $request->logo->move(public_path('uploads/stores'), $fileName);

            @unlink(public_path('uploads/stores/' . $store->logo));

            $store->logo = $fileName;
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

        return redirect()->route('seller.store')->with('success', 'Store updated successfully!');
    }
}
