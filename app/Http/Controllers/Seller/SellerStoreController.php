<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerStoreController extends Controller
{
    // Ambil toko milik seller
    protected function sellerStore()
    {
        return Store::where('user_id', Auth::id())->firstOrFail();
    }

    // Halaman edit toko
    public function edit()
    {
        $store = $this->sellerStore();
        return view('seller.store.edit', compact('store'));
    }

    // Update data toko
    public function update(Request $request)
    {
        $store = $this->sellerStore();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'city'  => 'required|string|max:255',
            'address' => 'required|string',
            'bank_name'           => 'required|string|max:100',
            'bank_account_number' => 'required|string|max:50',
            'bank_account_name'   => 'required|string|max:100',
        ]);

        $store->update($data);

        return back()->with('success', 'Profil toko diperbarui');
    }
}
