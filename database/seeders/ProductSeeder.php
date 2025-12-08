<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create categories first
        $categories = [
            ['name' => 'Sneakers', 'description' => 'Casual and stylish sneakers'],
            ['name' => 'Running Shoes', 'description' => 'Performance running shoes'],
            ['name' => 'Loafers', 'description' => 'Comfortable slip-on shoes'],
            ['name' => 'Boots', 'description' => 'Durable boots'],
            ['name' => 'Sandals', 'description' => 'Lightweight sandals'],
        ];

        foreach ($categories as $cat) {
            ProductCategory::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'description' => $cat['description'],
                ]
            );
        }

        // Get the seller's store
        $store = Store::first();
        if (!$store) {
            $this->command->warn('No store found. Please run SellerSeeder first.');
            return;
        }

        // Sample products
        $products = [
            ['name' => 'Air Max Classic White', 'description' => 'Iconic white sneakers with maximum comfort and breathable design.', 'price' => 850000, 'stock' => 15, 'category' => 'Sneakers'],
            ['name' => 'Urban Black Sneakers', 'description' => 'Sleek black sneakers perfect for urban style.', 'price' => 650000, 'stock' => 20, 'category' => 'Sneakers'],
            ['name' => 'Retro Blue Runners', 'description' => 'Vintage-inspired blue sneakers with modern comfort.', 'price' => 750000, 'stock' => 12, 'category' => 'Sneakers'],
            ['name' => 'Pro Runner 3000', 'description' => 'Professional running shoes with advanced cushioning.', 'price' => 1200000, 'stock' => 10, 'category' => 'Running Shoes'],
            ['name' => 'Speed Boost Elite', 'description' => 'High-performance running shoes designed for speed.', 'price' => 1500000, 'stock' => 8, 'category' => 'Running Shoes'],
            ['name' => 'Classic Brown Loafers', 'description' => 'Elegant brown leather loafers for professionals.', 'price' => 900000, 'stock' => 18, 'category' => 'Loafers'],
            ['name' => 'Navy Suede Loafers', 'description' => 'Sophisticated navy suede loafers.', 'price' => 950000, 'stock' => 14, 'category' => 'Loafers'],
            ['name' => 'Mountain Hiker Boots', 'description' => 'Rugged hiking boots for tough terrains.', 'price' => 1100000, 'stock' => 12, 'category' => 'Boots'],
            ['name' => 'Chelsea Ankle Boots', 'description' => 'Stylish brown chelsea boots.', 'price' => 880000, 'stock' => 16, 'category' => 'Boots'],
            ['name' => 'Beach Sandals', 'description' => 'Comfortable sandals for summer.', 'price' => 250000, 'stock' => 30, 'category' => 'Sandals'],
            ['name' => 'Sport Slide Sandals', 'description' => 'Athletic sandals with cushioned footbed.', 'price' => 350000, 'stock' => 25, 'category' => 'Sandals'],
        ];

        foreach ($products as $p) {
            $category = ProductCategory::where('slug', Str::slug($p['category']))->first();
            
            if ($category) {
                Product::updateOrCreate(
                    ['slug' => Str::slug($p['name'])],
                    [
                        'name' => $p['name'],
                        'store_id' => $store->id,
                        'product_category_id' => $category->id,
                        'description' => $p['description'],
                        'price' => $p['price'],
                        'stock' => $p['stock'],
                        'condition' => 'new',
                        'weight' => 500,
                        'material' => 'Premium Synthetic Leather', // Default sample material
                        'sizes' => ["39", "40", "41", "42", "43", "44"], // Default sample sizes
                    ]
                );
            }
        }

        $this->command->info('✓ Products seeded successfully!');
    }
}
