<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\StoreBalance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function showRegisterForm()
    {
        if (Auth::user()->store) {
            return redirect('/seller/dashboard')
                ->with('info', 'You already have a store');
        }
        
        return view('seller.store.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);
        
        $validated['user_id'] = Auth::id();
        $validated['is_verified'] = false;
        
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }
        
        $store = Store::create($validated);
        
        // Create store balance
        StoreBalance::create([
            'store_id' => $store->id,
            'balance' => 0,
        ]);
        
        return redirect('/seller/dashboard')
            ->with('success', 'Store registered! Waiting for admin verification.');
    }
    
    public function edit()
    {
        $store = Auth::user()->store;
        
        if (!$store) {
            return redirect('/seller/store/register');
        }
        
        return view('seller.store.edit', compact('store'));
    }
    
    public function update(Request $request)
    {
        $store = Auth::user()->store;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);
        
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $validated['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }
        
        $store->update($validated);
        
        return back()->with('success', 'Store updated successfully!');
    }
}
