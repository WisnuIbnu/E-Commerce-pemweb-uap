<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display cart items
     */
    public function index()
    {
        $cartItems = Cart::where('user_id', Auth::id())
            ->with(['product.store', 'product.images'])
            ->get();

        $total = $cartItems->sum(function($item) {
            return $item->product->price * $item->quantity;
        });

        return view('user.cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        // Validasi quantity
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ], [
            'quantity.required' => 'Jumlah harus diisi',
            'quantity.min' => 'Jumlah minimal 1',
            'quantity.max' => 'Jumlah melebihi stok tersedia (' . $product->stock . ')',
        ]);

        // Check if out of stock
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Produk sedang habis!');
        }

        DB::beginTransaction();

        try {
            // Check if product already in cart
            $cartItem = Cart::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->first();

            if ($cartItem) {
                // Update quantity
                $newQuantity = $cartItem->quantity + $validated['quantity'];
                
                if ($newQuantity > $product->stock) {
                    return redirect()->back()->with('error', 'Jumlah total melebihi stok tersedia! (Stok: ' . $product->stock . ', Di keranjang: ' . $cartItem->quantity . ')');
                }
                
                $cartItem->update(['quantity' => $newQuantity]);
                $message = 'Jumlah produk di keranjang berhasil diupdate!';
            } else {
                // Create new cart item
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $product->id,
                    'quantity' => $validated['quantity'],
                ]);
                $message = 'Produk berhasil ditambahkan ke keranjang!';
            }

            DB::commit();

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $product = $cartItem->product;

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock
        ]);

        if ($validated['quantity'] > $product->stock) {
            return redirect()->back()->with('error', 'Jumlah melebihi stok tersedia!');
        }

        $cartItem->update(['quantity' => $validated['quantity']]);

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil diupdate!');
    }

    /**
     * Remove item from cart
     */
    public function remove($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dihapus dari keranjang!');
    }

    /**
     * Clear all cart items
     */
    public function clear()
    {
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('cart.index')->with('success', 'Keranjang berhasil dikosongkan!');
    }
}