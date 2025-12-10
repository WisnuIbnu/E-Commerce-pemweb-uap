<?php

namespace Database\Seeders;

use App\Models\TransactionDetail;
use Illuminate\Database\Seeder;

class TransactionDetailSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            [
                'id' => 1,
                'transaction_id' => 4,
                'product_id' => 61, 
                'qty' => 1,
                'subtotal' => 415000.00,
            ],
            [
                'id' => 2,
                'transaction_id' => 5,
                'product_id' => 62, 
                'qty' => 1,
                'subtotal' => 385000.00,
            ],
            [
                'id' => 3,
                'transaction_id' => 6,
                'product_id' => 49,
                'qty' => 1,
                'subtotal' => 525000.00,
            ],
            [
                'id' => 4,
                'transaction_id' => 7,
                'product_id' => 69,
                'qty' => 1,
                'subtotal' => 245000.00,
            ],
            [
                'id' => 5,
                'transaction_id' => 8,
                'product_id' => 65,
                'qty' => 1,
                'subtotal' => 345000.00,
            ],
        ];

        foreach ($details as $detail) {
            TransactionDetail::updateOrCreate(
                ['id' => $detail['id']],
                $detail
            );
        }
    }
}