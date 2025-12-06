<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class BuyerStoreController extends Controller
{
    public function create()
    {
        return view('buyer.store.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name',
            'phone' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
        ]);

        Store::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'is_verified' => 0,
        ]);

        return redirect()->route('buyer.store.status')->with('success', 'Aplikasi toko berhasil dibuat! Menunggu verifikasi admin.');
    }

    public function status()
    {
        $store = Store::where('user_id', auth()->id())->first();
        return view('buyer.store.status', ['store' => $store]);
    }
}