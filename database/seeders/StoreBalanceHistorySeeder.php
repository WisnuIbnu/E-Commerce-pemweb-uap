<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class StoreBalanceHistorySeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('store_balance_histories') || ! Schema::hasTable('store_balances')) {
            $this->command->warn('Skipping StoreBalanceHistorySeeder: tables missing.');
            return;
        }

        $now = Carbon::now();

        $balances = DB::table('store_balances')->pluck('id','store_id')->toArray();
        if (empty($balances)) {
            $this->command->warn('No store balances found. Run StoreBalanceSeeder first.');
            return;
        }

        $histories = [];
        foreach ($balances as $storeBalanceId) {
            // contoh income masuk 1-2 kali
            $histories[] = [
                'store_balance_id' => $storeBalanceId,
                'type' => 'income',
                'reference_id' => (string) Str::uuid(),
                'reference_type' => 'seed_demo',
                'amount' => rand(50000, 200000),
                'remarks' => 'Initial demo income',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('store_balance_histories')->insert($histories);
        $this->command->info('Inserted store balance histories (demo).');
    }
}
