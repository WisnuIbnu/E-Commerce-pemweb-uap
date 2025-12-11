<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProductReviewSeeder extends Seeder
{
    public function run()
    {
        if (!DB::table('transactions')->exists() || !DB::table('products')->exists()) {
            $this->command->warn('Transactions or products missing — skipping ProductReviewSeeder.');
            return;
        }

        $transactions = DB::table('transactions')->pluck('id')->toArray();
        $products = DB::table('products')->pluck('id')->toArray();
        $now = Carbon::now();

        $reviews = [
            [
                'transaction_id' => $transactions[0] ?? null,
                'product_id' => $products[0] ?? null,
                'rating' => 5,
                'review' => 'Produk sangat bagus, kualitasnya lembut untuk bayi!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'transaction_id' => $transactions[0] ?? null,
                'product_id' => $products[1] ?? null,
                'rating' => 4,
                'review' => 'Bahan nyaman dan lucu, anak saya suka!',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'transaction_id' => $transactions[0] ?? null,
                'product_id' => $products[2] ?? null,
                'rating' => 5,
                'review' => 'Boneka sangat empuk, cocok buat bayi.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('product_reviews')->insert($reviews);

        $this->command->info('Inserted sample product reviews.');
    }
}
