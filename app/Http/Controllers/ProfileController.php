<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        // Update user data
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        
        // Update password if provided
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }
            
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        // Update buyer profile if exists
        if ($user->role === 'buyer' && $user->buyer) {
            $buyer = $user->buyer;
            
            if ($request->filled('phone_number')) {
                $buyer->phone_number = $validated['phone_number'];
            }
            
            if ($request->hasFile('profile_picture')) {
                // Delete old image
                if ($buyer->profile_picture) {
                    Storage::disk('public')->delete($buyer->profile_picture);
                }
                
                // Upload new image
                $path = $request->file('profile_picture')->store('profiles', 'public');
                $buyer->profile_picture = $path;
            }
            
            $buyer->save();
        }
        
        return back()->with('success', 'Profile updated successfully!');
    }
}