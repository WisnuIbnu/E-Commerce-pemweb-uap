<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SaldoController extends Controller
{
    public function create()
    {
        return view('front.saldo.topup');
    }
    
public function store(Request $request)
{
    // Pastikan validasi minimum disetel ke 1000 sesuai form
    $request->validate([
        'jumlah' => 'required|numeric|min:1000', // Ganti min:1 menjadi min:1000
    ]);

    $user = auth()->user();
    
    // Pastikan nilai yang ditambahkan adalah float/integer yang benar
    $jumlahTopUp = (int) $request->jumlah; 
    
    // Perbarui saldo
    $user->saldo += $jumlahTopUp;
    
    // Cek apakah kolom 'saldo' ada di model atau perlu ditambahkan di $fillable jika menggunakan Model::update()
    // Karena Anda menggunakan $user->save(), ini biasanya tidak menjadi masalah.

    try {
        $user->save(); // Lakukan penyimpanan

        // Redirect dengan pesan sukses
        return redirect()->route('dashboard')
                         ->with('success', 'Saldo Rp ' . number_format($jumlahTopUp, 0, ',', '.') . ' berhasil ditambahkan!');

    } catch (\Exception $e) {
        // Jika ada error (misalnya, masalah database atau kolom tidak ada)
        // Anda bisa log error-nya dan mengarahkan kembali dengan pesan error.
        \Log::error('Gagal menyimpan saldo:', ['error' => $e->getMessage(), 'user_id' => $user->id]);

        return redirect()->back()
                         ->with('error', 'Terjadi kesalahan saat menyimpan saldo. Silakan coba lagi. Error: ' . $e->getMessage());
    }
}
}
