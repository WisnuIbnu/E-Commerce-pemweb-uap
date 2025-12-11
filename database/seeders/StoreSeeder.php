<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();

        if (! $seller) {
            return;
        }

        Store::updateOrCreate(
            ['user_id' => $seller->id],
            [
                'name' => 'Toko Sembako Murah Meriah',
                'logo' => 'default-store.png',
                'about' => 'Menjual kebutuhan pokok sehari-hari dengan harga merakyat.',
                'phone' => '08123456789',
                'address_id' => 'ADDR001',
                'city' => 'Jakarta',
                'address' => 'Jl. Sembako Raya No. 12',
                'postal_code' => '12345',
                'is_verified' => 1,
                'status' => 'approved',
                'bank_name' => 'BCA',
                'bank_account_number' => '1234567890',
                'bank_account_name' => 'Toko Sembako',
            ]
        );
    }
}
