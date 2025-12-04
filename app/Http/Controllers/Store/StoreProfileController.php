<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreProfileController extends Controller
{
    public function edit()
    {
        $store = auth()->user()->store;
        return view('store.profile.edit', compact('store'));
    }

    public function update(Request $request)
    {
        $store = auth()->user()->store;

        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'about' => 'required|string',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'required|string|max:10',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('stores/logos', 'public');
        }

        $store->update($data);

        return redirect()->route('store.profile.edit')
            ->with('success', 'Store profile updated successfully');
    }

    public function destroy()
    {
        $store = auth()->user()->store;

        // Check if store has pending orders
        $hasPendingOrders = $store->transactions()
            ->whereIn('payment_status', ['pending', 'processing', 'shipped'])
            ->exists();

        if ($hasPendingOrders) {
            return back()->with('error', 'Cannot delete store with pending orders');
        }

        // Delete logo
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }

        $store->delete();

        // Update user role back to customer
        auth()->user()->update(['role' => 'customer']);

        return redirect()->route('home')
            ->with('success', 'Store deleted successfully');
    }
}