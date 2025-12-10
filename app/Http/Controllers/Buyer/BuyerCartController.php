<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class BuyerCartController extends Controller
{
    const CART_STATUS = 'cart';

    public function index()
    {
        $cartItems = auth()->user()->orders()
            ->where('status', self::CART_STATUS)
            ->with('product.images', 'product.store')
            ->get();
        
        return view('buyer.cart.index', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $user = auth()->user();
            $product = Product::findOrFail($request->product_id);

            // Validasi stok
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup. Stok tersedia: ' . $product->stock
                ], 422);
            }

            // Cek apakah produk sudah ada di keranjang user
            $existingItem = Order::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('status', self::CART_STATUS)
                ->first();

            if ($existingItem) {
                // Update quantity jika sudah ada
                $newQty = $existingItem->quantity + $request->quantity;
                
                // Validasi total stok
                if ($product->stock < $newQty) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Total stok tidak cukup. Stok tersedia: ' . $product->stock
                    ], 422);
                }
                
                $existingItem->update([
                    'quantity' => $newQty,
                    'total_price' => $product->price * $newQty,
                ]);
            } else {
                // Buat record baru di tabel orders dengan status 'cart'
                Order::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'quantity' => $request->quantity,
                    'total_price' => $product->price * $request->quantity,
                    'status' => self::CART_STATUS,
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke keranjang'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function update($id, Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $item = Order::where('user_id', auth()->id())
                ->where('id', $id)
                ->where('status', self::CART_STATUS)
                ->firstOrFail();

            $product = $item->product;

            // Validasi stok
            if ($product->stock < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Stok tidak cukup. Stok tersedia: ' . $product->stock
                ], 422);
            }

            $item->update([
                'quantity' => $request->quantity,
                'total_price' => $product->price * $request->quantity,
            ]);
            
            return response()->json([
                'success' => true,
                'message' => 'Kuantitas berhasil diperbarui'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
    
    public function delete($id)
    {
        try {
            $item = Order::where('user_id', auth()->id())
                ->where('id', $id)
                ->where('status', self::CART_STATUS)
                ->firstOrFail();

            $item->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}