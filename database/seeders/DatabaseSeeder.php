<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Store;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::create([
            'name' => 'Admin SORAÉ',
            'email' => 'admin@sorae.com',
            'password' => Hash::make('password'),
            'phone' => '081234567890',
            'role' => 'admin',
            'email_verified_at' => now()
        ]);

        // Create Buyer Users
        $buyer1 = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567891',
            'role' => 'buyer',
            'email_verified_at' => now()
        ]);

        $buyer2 = User::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567892',
            'role' => 'buyer',
            'email_verified_at' => now()
        ]);

        // Create Seller User with Approved Store
        $seller1 = User::create([
            'name' => 'Fashion Store Owner',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567893',
            'role' => 'buyer',
            'email_verified_at' => now()
        ]);

        $store1 = Store::create([
            'buyer_id' => $seller1->id,
            'name' => 'Fashion Paradise',
            'description' => 'Your one-stop destination for trendy fashion. We offer the latest collections from top designers.',
            'email' => 'hello@fashionparadise.com',
            'phone' => '081234567893',
            'address' => 'Jl. Fashion Street No. 123, Jakarta',
            'status' => 'approved',
            'balance' => 5000000
        ]);

        // Create Another Seller with Pending Store
        $seller2 = User::create([
            'name' => 'New Seller',
            'email' => 'newseller@example.com',
            'password' => Hash::make('password'),
            'phone' => '081234567894',
            'role' => 'buyer',
            'email_verified_at' => now()
        ]);

        Store::create([
            'buyer_id' => $seller2->id,
            'name' => 'Trendy Boutique',
            'description' => 'A new boutique offering exclusive fashion items.',
            'email' => 'info@trendyboutique.com',
            'phone' => '081234567894',
            'address' => 'Jl. Style Avenue No. 456, Bandung',
            'status' => 'pending'
        ]);

        // Create Product Categories
        $categories = [
            [
                'name' => 'Men\'s Clothing',
                'slug' => 'mens-clothing',
                'description' => 'Fashion and apparel for men',
                'icon' => '👔'
            ],
            [
                'name' => 'Women\'s Clothing',
                'slug' => 'womens-clothing',
                'description' => 'Fashion and apparel for women',
                'icon' => '👗'
            ],
            [
                'name' => 'Accessories',
                'slug' => 'accessories',
                'description' => 'Fashion accessories and jewelry',
                'icon' => '👜'
            ],
            [
                'name' => 'Footwear',
                'slug' => 'footwear',
                'description' => 'Shoes and sandals',
                'icon' => '👟'
            ],
            [
                'name' => 'Bags',
                'slug' => 'bags',
                'description' => 'Handbags and backpacks',
                'icon' => '🎒'
            ]
        ];

        foreach ($categories as $categoryData) {
            ProductCategory::create($categoryData);
        }

        // Create Sample Products
        $products = [
            [
                'name' => 'Premium Cotton T-Shirt',
                'description' => 'High-quality cotton t-shirt with modern fit. Perfect for casual wear.',
                'price' => 150000,
                'stock' => 50,
                'season' => 'all',
                'category_id' => 1
            ],
            [
                'name' => 'Elegant Summer Dress',
                'description' => 'Light and breezy summer dress perfect for warm weather.',
                'price' => 350000,
                'stock' => 30,
                'season' => 'summer',
                'category_id' => 2
            ],
            [
                'name' => 'Leather Messenger Bag',
                'description' => 'Genuine leather messenger bag with multiple compartments.',
                'price' => 750000,
                'stock' => 20,
                'season' => 'all',
                'category_id' => 5
            ],
            [
                'name' => 'Classic Denim Jeans',
                'description' => 'Comfortable denim jeans with a classic fit.',
                'price' => 250000,
                'stock' => 40,
                'season' => 'all',
                'category_id' => 1
            ],
            [
                'name' => 'Silk Scarf',
                'description' => 'Luxurious silk scarf with elegant patterns.',
                'price' => 180000,
                'stock' => 25,
                'season' => 'all',
                'category_id' => 3
            ],
            [
                'name' => 'Winter Wool Coat',
                'description' => 'Warm wool coat perfect for cold winter days.',
                'price' => 850000,
                'stock' => 15,
                'season' => 'winter',
                'category_id' => 2
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'store_id' => $store1->id,
                'category_id' => $productData['category_id'],
                'name' => $productData['name'],
                'description' => $productData['description'],
                'price' => $productData['price'],
                'stock' => $productData['stock'],
                'season' => $productData['season']
            ]);

            // Add placeholder image
            ProductImage::create([
                'product_id' => $product->id,
                'image_url' => 'products/placeholder.jpg',
                'is_primary' => true,
                'order' => 0
            ]);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin Email: admin@sorae.com');
        $this->command->info('Admin Password: password');
        $this->command->info('Seller Email: seller@example.com');
        $this->command->info('Seller Password: password');
    }
}

