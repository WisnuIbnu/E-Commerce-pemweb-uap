<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('user.products.index');
    }

    public function show($id)
    {
        return view('user.products.show', compact('id'));
    }
}
