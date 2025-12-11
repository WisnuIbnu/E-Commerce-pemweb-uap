<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\User;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        echo "\n[StoreSeeder] Run executed\n";

        $users = User::take(4)->get(); // gunakan 4 user pertama

        if ($users->count() < 1) {
            echo "[StoreSeeder] NO USERS FOUND\n";
            return;
        }

        echo "[StoreSeeder] Users found: " . $users->count() . "\n";

        $stores = [
            // Store 1 (verified)
            [
                'name' => 'Toko Dessert Manis',
                'logo' => 'dessert-manis.png',
                'about' => 'Toko khusus dessert & makanan manis',
                'phone' => '08111111111',
                'address_id' => 'DSS-001',
                'city' => 'Malang',
                'address' => 'Jl. Manis No. 1',
                'postal_code' => '65100',
                'is_verified' => true,
            ],

            // Store 2 (unverified)
            [
                'name' => 'Cupcake Heaven',
                'logo' => 'cupcake-heaven.png',
                'about' => 'Cupcake premium dengan topping bervariasi',
                'phone' => '08222222222',
                'address_id' => 'CPK-002',
                'city' => 'Surabaya',
                'address' => 'Jl. Gula No. 22',
                'postal_code' => '60200',
                'is_verified' => false,
            ],

            // Store 3 (unverified)
            [
                'name' => 'Brownies Coklat Legit',
                'logo' => 'brownies-legit.png',
                'about' => 'Brownies coklat premium lembut dan lumer di mulut',
                'phone' => '08333333333',
                'address_id' => 'BWL-003',
                'city' => 'Bandung',
                'address' => 'Jl. Coklat No. 5',
                'postal_code' => '40100',
                'is_verified' => false,
            ],

            // Store 4 (verified)
            [
                'name' => 'Es Krim Manis Manja',
                'logo' => 'icecream-manja.png',
                'about' => 'Es krim handmade dengan berbagai rasa unik',
                'phone' => '08444444444',
                'address_id' => 'ESK-004',
                'city' => 'Yogyakarta',
                'address' => 'Jl. Es No. 10',
                'postal_code' => '55100',
                'is_verified' => true,
            ],
        ];

        foreach ($users as $i => $user) {
            if (!isset($stores[$i])) break;

            Store::create(array_merge(
                $stores[$i],
                ['user_id' => $user->id]
            ));

            echo "[StoreSeeder] Inserted store for user ID {$user->id}: {$stores[$i]['name']}\n";
        }

        echo "[StoreSeeder] All stores inserted!\n";
    }
}
