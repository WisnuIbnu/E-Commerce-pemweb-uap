<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('dashboard', compact('users'));
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'status' => 'required|in:admin,seller,buyer'
        ]);

        $user->status = $request->status;
        $user->save();

        return redirect()->route('dashboard')->with('success', 'User status updated successfully.');
    }
}
