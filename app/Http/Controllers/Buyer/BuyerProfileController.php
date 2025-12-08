<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BuyerProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        // Pastikan ini hanya untuk role buyer
        if ($user->role !== 'buyer') {
            abort(403, 'Unauthorized');
        }

        return view('buyer.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($user->role !== 'buyer') {
            abort(403, 'Unauthorized');
        }

        $user->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
