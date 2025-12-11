<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SellerRequestController extends Controller
{
    // member mengajukan permintaan menjadi seller
    public function request(Request $request)
    {
        $user = auth()->user();

        if ($user->store_request_status !== 'none') {
            return response()->json([
                'message' => 'Anda sudah pernah mengajukan sebelumnya.'
            ], 400);
        }

        $user->update([
            'store_request_status' => 'pending'
        ]);

        return response()->json([
            'message' => 'Pengajuan diterima. Menunggu persetujuan admin.'
        ]);
    }
}
