<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ProductImageSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('product_images') || ! Schema::hasTable('products')) {
            $this->command->warn('Table product_images or products missing, skipping ProductImageSeeder.');
            return;
        }

        $now = Carbon::now();
        $productIds = DB::table('products')->pluck('id')->toArray();
        if (empty($productIds)) {
            $this->command->warn('No products found, skipping product images.');
            return;
        }

        $images = [];
        foreach ($productIds as $pid) {
            $images[] = [
                'product_id' => $pid,
                'image' => "images/products/{$pid}-1.jpeg",  // ✅ GANTI DISINI
                'is_thumbnail' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ];
            $images[] = [
                'product_id' => $pid,
                'image' => "images/products/{$pid}-2.jpeg",  // ✅ GANTI DISINI
                'is_thumbnail' => false,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('product_images')->insert($images);
        $this->command->info('Inserted product images for products.');
    }
}