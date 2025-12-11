<?php

namespace Database\Seeders;

use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $transactions = [
            [
                'id' => 4,
                'code' => 'TRX-EN7WHLOQYR',
                'buyer_id' => 1,
                'store_id' => 1,
                'address' => 'Dadapan, Solokuro, Lamongan',
                'address_id' => null,
                'city' => 'Kab. Lamongan',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'regular',
                'shipping_cost' => 15000.00,
                'tracking_number' => null,
                'tax' => 45650.00,
                'grand_total' => 475650.00,
                'payment_status' => 'paid',
                'created_at' => '2025-12-07 08:51:04',
                'updated_at' => '2025-12-07 08:52:57',
            ],
            [
                'id' => 5,
                'code' => 'TRX-OOACLPPVZL',
                'buyer_id' => 1,
                'store_id' => 1,
                'address' => 'Jl. Veteran, Ketawanggede, Lowokwaru, Malang, Jawa Timur',
                'address_id' => null,
                'city' => 'KOTA KEDIRI',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'regular',
                'shipping_cost' => 15000.00,
                'tracking_number' => null,
                'tax' => 42350.00,
                'grand_total' => 442350.00,
                'payment_status' => 'paid',
                'created_at' => '2025-12-07 09:08:12',
                'updated_at' => '2025-12-07 09:08:19',
            ],
            [
                'id' => 6,
                'code' => 'TRX-HNUEJFZT0Z',
                'buyer_id' => 1,
                'store_id' => 1,
                'address' => 'Dadapan, Solokuro, Lamongan',
                'address_id' => null,
                'city' => 'Kab. Lamongan',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'express',
                'shipping_cost' => 25000.00,
                'tracking_number' => null,
                'tax' => 57750.00,
                'grand_total' => 607750.00,
                'payment_status' => 'paid',
                'created_at' => '2025-12-07 09:24:36',
                'updated_at' => '2025-12-07 09:24:42',
            ],
            [
                'id' => 7,
                'code' => 'TRX-PXP3HS1BZV',
                'buyer_id' => 1,
                'store_id' => 1,
                'address' => 'Jl. Veteran, Ketawanggede, Lowokwaru, Malang, Jawa Timur',
                'address_id' => null,
                'city' => 'KOTA KEDIRI',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'express',
                'shipping_cost' => 25000.00,
                'tracking_number' => null,
                'tax' => 26950.00,
                'grand_total' => 296950.00,
                'payment_status' => 'paid',
                'created_at' => '2025-12-07 09:36:33',
                'updated_at' => '2025-12-07 09:37:30',
            ],
            [
                'id' => 8,
                'code' => 'TRX-22NIQL8P5F',
                'buyer_id' => 1,
                'store_id' => 1,
                'address' => 'Dadapan, Solokuro, Lamongan',
                'address_id' => null,
                'city' => 'Kab. Lamongan',
                'postal_code' => '12345',
                'shipping' => 'JNE',
                'shipping_type' => 'express',
                'shipping_cost' => 25000.00,
                'tracking_number' => null,
                'tax' => 37950.00,
                'grand_total' => 407950.00,
                'payment_status' => 'paid',
                'created_at' => '2025-12-07 09:44:09',
                'updated_at' => '2025-12-07 09:56:04',
            ],
        ];

        foreach ($transactions as $transaction) {
            Transaction::updateOrCreate(
                ['id' => $transaction['id']],
                $transaction
            );
        }
    }
}