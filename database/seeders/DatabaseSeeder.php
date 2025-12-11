<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);

        $this->call(ProductCategorySeeder::class);
        
        $this->call(StoreSeeder::class);
        
        $this->call(BuyerSeeder::class);
        
        $this->call(ProductSeeder::class);
        
        $this->call(ProductImageSeeder::class);
        
        $this->call(CartSeeder::class);
        
        $this->call(StoreBalanceSeeder::class);
        
        $this->call(TransactionSeeder::class);
        
        $this->call(TransactionDetailSeeder::class);
        
        $this->call(StoreBalanceHistorySeeder::class);
        
        $this->call(WithdrawalSeeder::class);
    }
}