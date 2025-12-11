<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'role' => 'admin',
                'password' => Hash::make('password'),
            ]
        );

        // Seller
        User::updateOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller Sembako',
                'role' => 'seller',
                'password' => Hash::make('password'),
            ]
        );

        // Buyer
        User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Buyer Biasa',
                'role' => 'buyer',
                'password' => Hash::make('password'),
            ]
        );
    }
}
