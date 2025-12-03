<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Product;

class CartController extends Controller
{
    public function add(Product $product)
    {
        
        session()->push('cart', $product);

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
