<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Second Admin',
            'email' => 'admin2@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);

        // Regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'member'
        ]);

        // Seller (tetap member di kolom role)
        $seller = User::create([
            'name' => 'Seller User',
            'email' => 'seller@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'seller'  
        ]);

        // Buat store untuk seller + verifikasi
        \App\Models\Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko Seller',
            'logo' => 'default.png',
            'about' => 'Toko default untuk testing',
            'phone' => '08123456789',
            'address_id' => 'AD001',
            'city' => 'Jakarta',
            'address' => 'Jalan testing',
            'postal_code' => '12345',
            'is_verified' => true,
        ]);
    }
}
