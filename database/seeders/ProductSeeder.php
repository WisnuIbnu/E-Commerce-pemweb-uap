<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('products')) {
            $this->command->warn('❌ Table products does not exist, skipping ProductSeeder.');
            return;
        }

        $now = Carbon::now();

        // Pastikan store ada
        $storeId = Schema::hasTable('stores') ? DB::table('stores')->value('id') : null;

        // Pastikan kategori ada
        $categoryIds = Schema::hasTable('product_categories')
            ? DB::table('product_categories')->pluck('id')->toArray()
            : [];

        // Jika store atau category tidak ada → hentikan
        if (!$storeId) {
            $this->command->error('❌ No store found. Run UserAndStoreSeeder first.');
            return;
        }

        if (empty($categoryIds)) {
            $this->command->error('❌ No categories found. Run ProductCategorySeeder first.');
            return;
        }

        // Pakai category pertama & kedua (jika ada)
        $cat1 = $categoryIds[0];
        $cat2 = $categoryIds[1] ?? $categoryIds[0];

        $products = [
            [
                'store_id' => $storeId,
                'product_category_id' => $cat1,
                'name' => 'Puffy Baby Cotton Romper',
                'slug' => Str::slug('Puffy Baby Cotton Romper'),
                'description' => 'Soft cotton romper for newborns.',
                'condition' => 'new',
                'price' => 120000.00,
                'weight' => 200,
                'stock' => 15,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'product_category_id' => $cat1,
                'name' => 'Puffy Baby Hoodie',
                'slug' => Str::slug('Puffy Baby Hoodie'),
                'description' => 'Cute hoodie for toddlers.',
                'condition' => 'new',
                'price' => 150000.00,
                'weight' => 300,
                'stock' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'store_id' => $storeId,
                'product_category_id' => $cat2,
                'name' => 'Soft Plush Toy Bear',
                'slug' => Str::slug('Soft Plush Toy Bear'),
                'description' => 'Huggable plush toy for babies.',
                'condition' => 'new',
                'price' => 80000.00,
                'weight' => 150,
                'stock' => 20,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('products')->insert($products);

        $this->command->info('✅ Inserted sample products successfully.');
    }
}
