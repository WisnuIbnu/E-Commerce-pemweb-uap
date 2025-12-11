<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan halaman keranjang
    public function index()
    {
        $carts = Cart::with(['product.store', 'variant']) 
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
        
        return view('front.carts', compact('carts'));
    }

    // Menyimpan produk ke keranjang
    public function store(Request $request, $slug)
    {
        $product = Product::with('variants')->where('slug', $slug)->firstOrFail();
    
        // Validasi input
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        // Cari Varian ID jika produk memiliki varian
        $variantId = null;
        if ($product->variants->count() > 0) {
            $variant = $product->variants()
                ->where('color', $request->color)
                ->where('size', $request->size)
                ->first();
            
            if (!$variant) {
                return redirect()->back()->with('error', 'Silakan pilih warna dan ukuran yang tersedia.');
            }
            $variantId = $variant->id;
        }

        // Cek duplikat di keranjang (Produk sama + Varian sama)
        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('product_variant_id', $variantId)
            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'product_variant_id' => $variantId,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('carts.index')->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }

    // Menghapus item dari keranjang
    public function destroy($id)
    {
        $cart = Cart::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $cart->delete();

        return redirect()->back()->with('success', 'Produk dihapus dari keranjang.');
    }
}