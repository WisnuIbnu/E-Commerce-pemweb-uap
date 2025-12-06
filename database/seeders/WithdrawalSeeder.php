<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class WithdrawalSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('withdrawals') || ! Schema::hasTable('store_balances')) {
            $this->command->warn('Skipping WithdrawalSeeder: tables missing.');
            return;
        }

        $now = Carbon::now();

        $storeBalanceIds = DB::table('store_balances')->pluck('id')->toArray();
        if (empty($storeBalanceIds)) {
            $this->command->warn('No store balances found. Run StoreBalanceSeeder first.');
            return;
        }

        // buat satu withdrawal contoh untuk first store balance
        $first = $storeBalanceIds[0] ?? null;
        if ($first && DB::table('withdrawals')->where('store_balance_id', $first)->count() == 0) {
            DB::table('withdrawals')->insert([
                'store_balance_id' => $first,
                'amount' => 50000.00,
                'bank_account_name' => 'Puffy Baby',
                'bank_account_number' => '1234567890',
                'bank_name' => 'BCA',
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            $this->command->info('Inserted an example withdrawal (pending).');
        } else {
            $this->command->info('Withdrawals exist or no store balance found, skipping.');
        }
    }
}
