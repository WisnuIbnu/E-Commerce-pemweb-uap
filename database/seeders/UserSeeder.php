<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'name' => 'Admin ELSHOP',
            'email' => 'admin@elshop.com',
            'email_verified_at' => now(),
            'role' => 'admin',
            'is_verified' => 1,
            'password' => Hash::make('password'),
        ]);

        // Member / Buyers (3 users)
        for ($i = 1; $i <= 3; $i++) {
            $user = User::create([
                'name' => "Buyer $i",
                'email' => "buyer$i@test.com",
                'email_verified_at' => now(),
                'role' => 'member',
                'is_verified' => 1,
                'password' => Hash::make('password'),
            ]);

            // Create buyer profile
            Buyer::create([
                'user_id' => $user->id,
                'profile_picture' => null,
                'phone_number' => '0812345678' . $i,
            ]);
        }

        // Member / Sellers (3 users untuk toko)
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'name' => "Seller $i",
                'email' => "seller$i@test.com",
                'email_verified_at' => now(),
                'role' => 'member',
                'is_verified' => 1,
                'password' => Hash::make('password'),
            ]);
        }
    }
}