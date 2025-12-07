<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::withCount('products')
            ->whereNull('parent_id')
            ->orderBy('name')
            ->take(6)
            ->get();

        return view('dashboard', compact('categories'));
    }
}