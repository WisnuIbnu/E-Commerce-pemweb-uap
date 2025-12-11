<?php

namespace Database\Seeders;

use App\Models\Cart;
use Illuminate\Database\Seeder;

class CartSeeder extends Seeder
{
    public function run(): void
    {
        Cart::updateOrCreate(
            ['id' => 4],
            [
                'user_id' => 7,
                'product_id' => 69,
                'quantity' => 1,
            ]
        );
    }
}