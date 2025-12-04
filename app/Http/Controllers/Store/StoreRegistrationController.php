<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreRegistrationController extends Controller
{
    public function create()
    {
        // Check if user already has a store
        if (auth()->user()->store) {
            return redirect()->route('store.dashboard');
        }

        return view('store.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        $logoPath = $request->file('logo')->store('stores/logos', 'public');

        $store = Store::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'logo' => $logoPath,
            'about' => $request->about,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'is_verified' => false,
        ]);

        // Create store balance
        StoreBalance::create([
            'store_id' => $store->id,
            'balance' => 0,
        ]);

        return redirect()->route('store.pending')
            ->with('success', 'Store registration submitted! Please wait for admin verification.');
    }

    public function pending()
    {
        $store = auth()->user()->store;

        if (!$store) {
            return redirect()->route('store.register');
        }

        if ($store->is_verified) {
            return redirect()->route('store.dashboard');
        }

        return view('store.pending', compact('store'));
    }
}