<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('store')->get();
        $stores = Store::all();

        return view('admin.users.index', compact('users', 'stores'));
    }
}
