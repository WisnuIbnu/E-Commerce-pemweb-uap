<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\StoreBalance;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get seller user
        $seller = User::where('email', 'seller@example.com')->first();

        if (!$seller) {
            echo "❌ Seller user not found. Run UserSeeder first!\n";
            return;
        }

        // Create store
        $store = Store::create([
            'user_id' => $seller->id,
            'name' => 'Tech Store',
            'logo' => 'stores/default-logo.png',
            'about' => 'Your one-stop shop for electronics and gadgets. We provide quality products with excellent service.',
            'phone' => '081234567890',
            'address' => 'Jl. Merdeka No. 123',
            'address_id' => 'ADDR001',
            'city' => 'Jakarta',
            'postal_code' => '12345',
            'is_verified' => true, // Already verified for testing
        ]);

        // Create store balance
        StoreBalance::create([
            'store_id' => $store->id,
            'balance' => 0,
        ]);

        echo "✅ Store created successfully!\n";
        echo "🏪 Store: {$store->name} (Verified)\n";
    }
}
