<?php

namespace Database\Seeders;

use App\Models\StoreBalance;
use Illuminate\Database\Seeder;

class StoreBalanceSeeder extends Seeder
{
    public function run(): void
    {
        $balances = [
            [
                'id' => 1,
                'store_id' => 3,
                'balance' => 39330000.00,
            ],
            [
                'id' => 2,
                'store_id' => 1,
                'balance' => 2190000.00,
            ],
            [
                'id' => 3,
                'store_id' => 2,
                'balance' => 725000.00,
            ],
        ];

        foreach ($balances as $balance) {
            StoreBalance::updateOrCreate(
                ['id' => $balance['id']],
                $balance
            );
        }
    }
}