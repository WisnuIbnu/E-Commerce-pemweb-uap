<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SellerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'seller@example.com'],
            [
                'name' => 'Seller User',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        // Seller usually also has a buyer profile
        Buyer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => '089876543210',
            ]
        );

        Store::updateOrCreate(
            ['user_id' => $user->id],
            [
                'name' => 'Seller Store',
                'logo' => 'default_store_logo.png',
                'about' => 'This is a default seller store.',
                'is_verified' => true,
                'phone' => '089876543210',
                'address_id' => '152', // Dummy ID (e.g., Jakarta Pusat)
                'city' => 'Jakarta',
                'address' => 'Jl. Jend. Sudirman',
                'postal_code' => '12190',
                // Add default logo or other fields if required
            ]
        );

        $this->command->info('Seller User created: seller@example.com / password');
    }
}
