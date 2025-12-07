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

        // Ambil kategori
        $categoryIds = Schema::hasTable('product_categories')
            ? DB::table('product_categories')->pluck('id')->toArray()
            : [];

        if (!$storeId) {
            $this->command->error('❌ No store found. Run UserAndStoreSeeder first.');
            return;
        }

        if (empty($categoryIds)) {
            $this->command->error('❌ No categories found. Run ProductCategorySeeder first.');
            return;
        }

        // Mapping kategori
        $babyWear      = $categoryIds[0];
        $toys          = $categoryIds[1];
        $accessories   = $categoryIds[2];
        $careBath      = $categoryIds[3];
        $shoes         = $categoryIds[4];
        $bags          = $categoryIds[5];

        // --- LIST PRODUK ---
        $products = [

            // Babywear
            ['Baby Cotton Romper', $babyWear, 'Soft romper for newborns', 120000, 150, 20],
            ['Baby Hoodie Soft Fleece', $babyWear, 'Warm fleece hoodie', 155000, 250, 14],
            ['Baby Pajamas Set', $babyWear, 'Comfortable pajama set', 135000, 230, 18],
            ['Newborn Swaddle Blanket', $babyWear, 'Soft swaddle blanket', 90000, 200, 30],

            // Toys
            ['Plush Bear Toy', $toys, 'Cute plush toy bear', 80000, 180, 20],
            ['Rattle Baby Toy', $toys, 'Colorful rattle toy', 45000, 80, 40],
            ['Stacking Ring Toy', $toys, 'Educational stacking toy', 65000, 150, 25],
            ['Soft Block Toy Set', $toys, 'Safe foam block toys', 120000, 300, 15],

            // Accessories
            ['Baby Cotton Hat', $accessories, 'Soft baby hat', 30000, 50, 50],
            ['Baby Socks Pack (3 pcs)', $accessories, 'Warm baby socks', 25000, 30, 60],
            ['Baby Mittens Set', $accessories, 'Prevent scratches', 20000, 25, 55],
            ['Baby Headband Bow', $accessories, 'Cute bow headband', 28000, 20, 40],

            // Care & Bath
            ['Baby Shampoo Gentle', $careBath, 'Safe shampoo for babies', 50000, 300, 30],
            ['Baby Lotion Mild', $careBath, 'Moisturizing baby lotion', 45000, 250, 35],
            ['Baby Powder Soft', $careBath, 'Gentle baby powder', 30000, 200, 40],
            ['Baby Bath Towel', $careBath, 'Soft absorbent towel', 70000, 400, 20],

            // Shoes
            ['Soft Baby Shoes', $shoes, 'Comfortable first step shoes', 60000, 150, 22],
            ['Baby Sneakers', $shoes, 'Light toddler sneakers', 85000, 250, 16],
            ['Baby Sandals', $shoes, 'Soft rubber sandals', 55000, 120, 25],

            // Bags
            ['Mommy Diaper Bag', $bags, 'Spacious diaper bag', 180000, 800, 10],
            ['Travel Milk Cooler Bag', $bags, 'Insulated cooler bag', 125000, 600, 12],
        ];

        // Format insert
        $insertData = [];
        foreach ($products as $p) {
            $insertData[] = [
                'store_id' => $storeId,
                'product_category_id' => $p[1],
                'name' => $p[0],
                'slug' => Str::slug($p[0]),
                'description' => $p[2],
                'condition' => 'new',
                'price' => $p[3],
                'weight' => $p[4],
                'stock' => $p[5],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('products')->insert($insertData);

        $this->command->info('✅ Inserted 20 sample products successfully.');
    }
}
