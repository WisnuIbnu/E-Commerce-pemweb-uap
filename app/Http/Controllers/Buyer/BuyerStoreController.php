<?php
// ============================================
// BuyerStoreController.php
// ============================================

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class BuyerStoreController extends Controller
{
    public function create()
    {
        // Check if user already has a store
        $existingStore = Store::where('user_id', auth()->id())->first();
        
        if ($existingStore) {
            return redirect()->route('buyer.store.status');
        }

        return view('buyer.store-apply');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Check if already has store
        $existingStore = Store::where('user_id', auth()->id())->first();
        
        if ($existingStore) {
            return redirect()->route('buyer.store.status')
                ->with('error', 'Anda sudah memiliki pengajuan toko!');
        }

        Store::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'status' => 'pending',
        ]);

        return redirect()->route('buyer.store.status')
            ->with('success', 'Pengajuan toko berhasil dikirim! Mohon tunggu persetujuan admin.');
    }

    public function status()
    {
        $store = Store::where('user_id', auth()->id())->first();
        
        if (!$store) {
            return redirect()->route('buyer.store.apply');
        }

        return view('buyer.store-status', compact('store'));
    }
}