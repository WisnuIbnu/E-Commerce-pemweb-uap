<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use Illuminate\Support\Facades\Hash;

class UserAndStoreSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Pastikan USER ada atau buat
        $seller = User::where('email', 'seller@example.com')->first();

        if (!$seller) {
            $seller = User::create([
                'name' => 'Puffy Seller',
                'email' => 'seller@example.com',
                'password' => Hash::make('password'),
                'role' => 'seller',
            ]);

            $this->command->info('Created seller user: seller@example.com');
        } else {
            $this->command->warn('Seller user already exists, skipping user creation.');
        }

        // 2. Pastikan STORE ada atau buat
        $store = Store::where('user_id', $seller->id)->first();

        if (!$store) {
            Store::create([
                'user_id' => $seller->id,
                'name' => 'Puffy Baby Official Store',
                'logo' => 'store-logo.png',
                'about' => 'Toko resmi perlengkapan bayi Puffy Baby!',
                'phone' => '081234567890',
                'address_id' => 'JKT001',
                'city' => 'Jakarta',
                'address' => 'Jalan Mawar No. 10',
                'postal_code' => '12345',
                'is_verified' => true,
            ]);

            $this->command->info('Created official store for seller.');
        } else {
            $this->command->warn('Store already exists for seller, skipping store creation.');
        }
    }
}
