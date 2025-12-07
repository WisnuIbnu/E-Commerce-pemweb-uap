<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::with('store')->get();

        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }

    public function show($id)
    {
        $user = User::with('store')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $user
        ]);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        Validator::make(['id' => $id], [
            'id' => 'different:' . auth()->id()
        ], [
            'different' => 'Admin tidak boleh menghapus dirinya sendiri'
        ])->validate();

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
}
