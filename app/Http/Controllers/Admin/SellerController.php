<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class SellerController extends Controller
{
    public function index()
    {
        $sellers = User::where('role', 'seller')->paginate(12);
        return view('admin.sellers', compact('sellers'));
    }
}