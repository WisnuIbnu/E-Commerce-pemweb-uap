<?php

namespace Database\Seeders;

use App\Models\Withdrawal;
use Illuminate\Database\Seeder;

class WithdrawalSeeder extends Seeder
{
    public function run(): void
    {
        $withdrawals = [
            [
                'id' => 1,
                'store_balance_id' => 1,
                'amount' => 1000000.00,
                'bank_account_name' => 'Jaehyun',
                'bank_account_number' => '1234567890',
                'bank_name' => 'Bank BCA',
                'status' => 'pending',
            ],
            [
                'id' => 2,
                'store_balance_id' => 1,
                'amount' => 700000.00,
                'bank_account_name' => 'Jaehyun',
                'bank_account_number' => '1234567890',
                'bank_name' => 'Bank BCA',
                'status' => 'pending',
            ],
            [
                'id' => 3,
                'store_balance_id' => 1,
                'amount' => 120000.00,
                'bank_account_name' => 'Jaehyun',
                'bank_account_number' => '1234567890',
                'bank_name' => 'Bank BCA',
                'status' => 'pending',
            ],
        ];

        foreach ($withdrawals as $withdrawal) {
            Withdrawal::updateOrCreate(
                ['id' => $withdrawal['id']],
                $withdrawal
            );
        }
    }
}