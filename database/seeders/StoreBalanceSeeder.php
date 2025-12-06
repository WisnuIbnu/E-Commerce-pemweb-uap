<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class StoreBalanceSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('store_balances') || ! Schema::hasTable('stores')) {
            $this->command->warn('Skipping StoreBalanceSeeder: tables missing.');
            return;
        }

        $now = Carbon::now();

        // buat balance untuk setiap store jika belum ada
        $stores = DB::table('stores')->pluck('id')->toArray();
        foreach ($stores as $storeId) {
            $exists = DB::table('store_balances')->where('store_id', $storeId)->exists();
            if (! $exists) {
                DB::table('store_balances')->insert([
                    'store_id' => $storeId,
                    'balance' => 0.00,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        $this->command->info('Store balances ensured.');
    }
}
