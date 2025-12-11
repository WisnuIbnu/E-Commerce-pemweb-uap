<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
        Buyer::updateOrCreate(
            ['id' => 1],
            [
                'user_id' => 7,
                'profile_picture' => null,
                'phone_number' => null,
            ]
        );
    }
}