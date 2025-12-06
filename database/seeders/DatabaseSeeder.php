<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // daftar seeder yang ingin dipanggil (nama class)
        $seeders = [
            'UserAndStoreSeeder',
            'ProductCategorySeeder',
            'ProductSeeder',
            'ProductImageSeeder',
            'BuyerSeeder',
            'StoreBalanceSeeder',
            'StoreBalanceHistorySeeder',
            'WithdrawalSeeder',
            'TransactionSeeder',
            'ProductReviewSeeder',
        ];

        foreach ($seeders as $seeder) {
            $full = "Database\\Seeders\\{$seeder}";

            if (class_exists($full)) {
                $this->call($full);
            } else {
                // tampilkan peringatan supaya kamu tahu seeder mana yang hilang
                $this->command->warn("Seeder class {$full} not found, skipping.");
            }
        }

        // fallback: create an admin user (only if User model exists)
        if (class_exists(\App\Models\User::class)) {
            \App\Models\User::factory()->create([
                'name' => 'admin',
                'email' => 'admin@example.com',
            ]);
        }
    }
}
