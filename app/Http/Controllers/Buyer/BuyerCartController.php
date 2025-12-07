<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerCartController extends Controller
{
    public function index()
    {
        // Ambil cart items dari database
        $cartItems = auth()->user()->cartItems ?? collect();
        
        return view('buyer.cart.index', compact('cartItems'));
    }
    
    public function add(Request $request)
    {
        // Logic untuk add to cart
        // Nanti disesuaikan dengan model Cart
        
        return response()->json(['success' => true]);
    }
    
    public function update($id, Request $request)
    {
        // Logic untuk update quantity
        
        return response()->json(['success' => true]);
    }
    
    public function delete($id)
    {
        // Logic untuk delete cart item
        
        return response()->json(['success' => true]);
    }
}