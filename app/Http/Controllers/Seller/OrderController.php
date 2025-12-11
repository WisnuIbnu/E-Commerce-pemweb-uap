<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = auth()->user()->store;
        // Eager load buyer and their user data
        $orders = \App\Models\Transaction::with('buyer.user')
                    ->where('store_id', $store->id)
                    ->latest()
                    ->get();
        return view('seller.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $store = auth()->user()->store;
        $transaction = \App\Models\Transaction::with(['details.product.productImages', 'buyer.user'])
                        ->where('store_id', $store->id)
                        ->findOrFail($id);
                        
        return view('seller.orders.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
