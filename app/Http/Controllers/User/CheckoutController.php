<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    public function index($product_id)
    {
        return view('user.checkout.index');
    }

    public function store()
    {
        return redirect()->route('transaction.history');
    }
}
