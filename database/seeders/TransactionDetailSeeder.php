<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class TransactionDetailSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('transaction_details') || ! Schema::hasTable('transactions') || ! Schema::hasTable('products')) {
            $this->command->warn('Skipping TransactionDetailSeeder: tables missing.');
            return;
        }

        // contoh sederhana: jika ada transaksi tanpa details, tambahkan 1 detail
        $now = Carbon::now();
        $txn = DB::table('transactions')->first();
        if (! $txn) {
            $this->command->warn('No transactions found to add details to.');
            return;
        }

        $product = DB::table('products')->first();
        if (! $product) {
            $this->command->warn('No products found for transaction details.');
            return;
        }

        DB::table('transaction_details')->insert([
            'transaction_id' => $txn->id,
            'product_id' => $product->id,
            'qty' => 1,
            'subtotal' => (float)$product->price,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $this->command->info('Inserted a transaction detail for first transaction.');
    }
}
