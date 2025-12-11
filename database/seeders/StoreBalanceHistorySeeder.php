<?php

namespace Database\Seeders;

use App\Models\StoreBalanceHistory;
use Illuminate\Database\Seeder;

class StoreBalanceHistorySeeder extends Seeder
{
    public function run(): void
    {
        $histories = [
            ['id' => 1, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '4', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 415000.00, 'remarks' => 'Order #TRX-EN7WHLOQYR completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 2, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '5', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 385000.00, 'remarks' => 'Order #TRX-OOACLPPVZL completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 3, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '6', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 525000.00, 'remarks' => 'Order #TRX-HNUEJFZT0Z completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 4, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '7', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 245000.00, 'remarks' => 'Order #TRX-PXP3HS1BZV completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 5, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '8', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 345000.00, 'remarks' => 'Order #TRX-22NIQL8P5F completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 6, 'store_balance_id' => 2, 'type' => 'income', 'reference_id' => '11', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 275000.00, 'remarks' => 'Order #TRX-7MOD2TGO4U completed', 'created_at' => '2025-12-08 08:21:35'],

            ['id' => 7, 'store_balance_id' => 3, 'type' => 'income', 'reference_id' => '9', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 725000.00, 'remarks' => 'Order #TRX-O7R9OLBR8D completed', 'created_at' => '2025-12-08 08:21:35'],

            ['id' => 8, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '12', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 40000000.00, 'remarks' => 'Order #TRX-XNYXZSGST2 completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 9, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '13', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 150000.00, 'remarks' => 'Order #TRX-RKY4EGHGC8 completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 10, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '14', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 250000.00, 'remarks' => 'Order #TRX-MN7DJ7DREK completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 11, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '17', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 250000.00, 'remarks' => 'Order #TRX-YMOUNNXOW5 completed', 'created_at' => '2025-12-08 08:21:35'],
            ['id' => 12, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '15', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 250000.00, 'remarks' => 'Order #TRX-GG5HICECUK completed', 'created_at' => '2025-12-08 08:23:59'],
            ['id' => 13, 'store_balance_id' => 1, 'type' => 'income', 'reference_id' => '16', 'reference_type' => 'App\\Models\\Transaction', 'amount' => 250000.00, 'remarks' => 'Order #TRX-SGFYAPD3EH completed', 'created_at' => '2025-12-08 08:24:11'],

            ['id' => 14, 'store_balance_id' => 1, 'type' => 'withdraw', 'reference_id' => '1', 'reference_type' => 'App\\Models\\Withdrawal', 'amount' => 1000000.00, 'remarks' => 'Withdrawal request #1', 'created_at' => '2025-12-08 08:45:49'],
            ['id' => 15, 'store_balance_id' => 1, 'type' => 'withdraw', 'reference_id' => '2', 'reference_type' => 'App\\Models\\Withdrawal', 'amount' => 700000.00, 'remarks' => 'Withdrawal request #2', 'created_at' => '2025-12-08 08:50:39'],
            ['id' => 16, 'store_balance_id' => 1, 'type' => 'withdraw', 'reference_id' => '3', 'reference_type' => 'App\\Models\\Withdrawal', 'amount' => 120000.00, 'remarks' => 'Withdrawal request #3', 'created_at' => '2025-12-08 08:51:14'],
        ];

        foreach ($histories as $history) {
            StoreBalanceHistory::updateOrCreate(
                ['id' => $history['id']],
                $history
            );
        }
    }
}