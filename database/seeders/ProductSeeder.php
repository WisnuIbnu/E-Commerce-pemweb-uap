<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Store;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $store = Store::first();

        if (!$store) {
            echo "❌ Store not found. Run StoreSeeder first!\n";
            return;
        }

        $electronics = ProductCategory::where('slug', 'electronics')->first();
        $fashion = ProductCategory::where('slug', 'fashion')->first();

        if (!$electronics || !$fashion) {
            echo "❌ Categories not found. Run CategorySeeder first!\n";
            return;
        }

        $products = [
            [
                'category_id' => $electronics->id,
                'name' => 'Smartphone XYZ Pro',
                'description' => 'Latest flagship smartphone with amazing camera and long battery life. Features include 5G connectivity, 6.5" AMOLED display, and 128GB storage.',
                'condition' => 'new',
                'price' => 5999000,
                'weight' => 200,
                'stock' => 50,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Wireless Earbuds Premium',
                'description' => 'True wireless earbuds with active noise cancellation. Crystal clear sound quality and 24-hour battery life with charging case.',
                'condition' => 'new',
                'price' => 899000,
                'weight' => 50,
                'stock' => 100,
            ],
            [
                'category_id' => $electronics->id,
                'name' => 'Laptop Gaming Beast',
                'description' => 'High-performance gaming laptop with RTX 4060, Intel i7 processor, 16GB RAM, and 512GB SSD. Perfect for gaming and content creation.',
                'condition' => 'new',
                'price' => 15999000,
                'weight' => 2500,
                'stock' => 20,
            ],
            [
                'category_id' => $fashion->id,
                'name' => 'Classic T-Shirt',
                'description' => 'Comfortable cotton t-shirt available in various colors. Made from premium cotton material, soft and breathable.',
                'condition' => 'new',
                'price' => 99000,
                'weight' => 200,
                'stock' => 200,
            ],
            [
                'category_id' => $fashion->id,
                'name' => 'Denim Jeans',
                'description' => 'Stylish denim jeans with modern fit. Durable and comfortable for everyday wear.',
                'condition' => 'new',
                'price' => 299000,
                'weight' => 500,
                'stock' => 150,
            ],
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'store_id' => $store->id,
                'product_category_id' => $productData['category_id'],
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'condition' => $productData['condition'],
                'price' => $productData['price'],
                'weight' => $productData['weight'],
                'stock' => $productData['stock'],
            ]);

            // Create dummy product image
            ProductImage::create([
                'product_id' => $product->id,
                'image' => 'products/default-product.png',
                'is_thumbnail' => true,
            ]);

            echo "✅ Product created: {$product->name}\n";
        }

        echo "\n✅ All products created successfully!\n";
    }
}
