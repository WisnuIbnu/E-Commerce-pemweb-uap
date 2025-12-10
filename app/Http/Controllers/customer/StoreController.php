<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show($id)
    {
        $store = Store::with(['products'])->findOrFail($id);
        
        return view('customer.store.show', compact('store'));
    }
}
