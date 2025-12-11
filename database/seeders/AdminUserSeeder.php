<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan user ID 1 kalau ada jadi admin
        if ($user = User::find(1)) {
            $user->role = 'admin';
            $user->save();
        }

        // Insert user admin baru (jika belum ada)
        User::updateOrCreate(
            ['email' => 'admin2@example.com'], // kondisi
            [
                'name' => 'Admin PuffyBaby',
                'password' => Hash::make('password123'),
                'role' => 'admin'
            ] // data
        );
    }
}
