<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    // Dashboard admin
    public function dashboard() {
        return view('admin.dashboard');
    }

    // Lihat semua user biasa
    public function listUsers() {
        $users = User::where('role', 'buyer')->get();
        return view('admin.users', compact('users'));
    }

    // Lihat semua seller
    public function listSellers() {
        $sellers = User::where('role', 'seller')->get();
        return view('admin.sellers', compact('sellers'));
    }

    // Hapus user
    public function deleteUser($id) {
        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully');
    }

    // Lihat semua produk snack
    public function listProducts() {
        $products = Product::all();
        return view('admin.products', compact('products'));
    }

    // Hapus produk
    public function deleteProduct($id) {
        Product::findOrFail($id)->delete();
        return back()->with('success', 'Product deleted successfully');
    }

    // Lihat semua order
    public function listOrders() {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }
}