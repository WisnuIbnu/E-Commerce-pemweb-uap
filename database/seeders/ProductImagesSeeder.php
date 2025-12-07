<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            echo "Tidak ada product, jalankan ProductSeeder dulu.\n";
            return;
        }

        foreach ($products as $product) {

            // Thumbnail
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'product_assets/' . $product->id . '_thumb.png',
                'is_thumbnail' => true,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'product_assets/' . $product->id . '_1.png',
                'is_thumbnail' => false,
            ]);

            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'product_assets/' . $product->id . '_2.png',
                'is_thumbnail' => false,
            ]);
            echo "Seeded images for product: {$product->name}\n";
        }
    }
}
