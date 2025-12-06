<?php
namespace App\Http\Controllers\Buyer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuyerProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        return view('buyer.profile.edit', ['user' => $user]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = auth()->user();
        $user->update($request->all());

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}