<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Store;
use App\Models\Buyer;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\ProductVariant; // Import Model Varian
use App\Models\StoreBalance;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // membuat user admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);

        // membuat user seller
        $seller = User::create([
            'name' => 'Noel',
            'email' => 'noel@gmail.com',
            'password' => Hash::make('seller'),
            'role' => 'member', 
        ]);

        // membuat data toko untuk seller
        $store = Store::create([
            'user_id' => $seller->id,
            'name' => 'Tech Store',
            'logo' => 'Tech-store.jpg',
            'about' => 'Toko elektronik terlengkap dan terpercaya.',
            'phone' => '085895311686',
            'address_id' => '1',
            'address' => 'Jl. Veteran No. 50', 
            'city' => 'Malang',
            'postal_code' => '121212',
            'is_verified' => true,
        ]);

        // membuat saldo toko
        StoreBalance::create([
            'store_id' => $store->id,
            'balance' => 0,
        ]);

        // membuat user buyer
        $buyer = User::create([
            'name' => 'Arkadian',
            'email' => 'arkadian@gmail.com',
            'password' => Hash::make('buyer'),
            'role' => 'member',
        ]);

        // membuat data buyer
        Buyer::create([
            'user_id' => $buyer->id,
            'phone_number' => '085648128017',
        ]);

        // membuat kategori produk
        $catElektronik = ProductCategory::create([
            'name' => 'Elektronik',
            'slug' => 'elektronik',
            'description' => 'Komputer, laptop, handphone, dan lainnya',
            'image' => 'elektronik.jpg'
        ]);

        $catAccessories = ProductCategory::create([
            'name' => 'Accesssories',
            'slug' => 'accessories',
            'description' => 'Hedset, casing, charger, dan lainnya',
            'image' => 'accessories.png'
        ]);

        // ==========================================
        // MEMBUAT PRODUK DAN VARIAN
        // ==========================================

        // --- PRODUK 1: Lenovo ThinkPad ---
        $product1 = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $catElektronik->id,
            'name' => 'Lenovo ThinkPad X1 Carbon',
            'slug' => 'lenovo-thinkpad-x1-carbon',
            'description' => 'Laptop bisnis tangguh dengan performa tinggi.',
            'condition' => 'new',
            'price' => 28000000, // Harga dasar
            'weight' => 2500,
            'stock' => 10,
        ]);

        ProductImage::create([
            'product_id' => $product1->id,
            'image' => 'thinkpad.jpg',
            'is_thumbnail' => true,
        ]);

        // Varian Produk 1 (Contoh: Warna & Ukuran Layar/RAM)
        ProductVariant::create([
            'product_id' => $product1->id,
            'color' => 'Matte Black',
            'size' => '16GB RAM',
            'price' => 28000000, // Harga sama dengan dasar
            'stock' => 5,
        ]);
        ProductVariant::create([
            'product_id' => $product1->id,
            'color' => 'Carbon Fiber',
            'size' => '32GB RAM',
            'price' => 32000000, // Harga lebih mahal
            'stock' => 3,
        ]);


        // --- PRODUK 2: Casing iPhone ---
        $product2 = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $catAccessories->id,
            'name' => 'Casing iPhone 12 Pro Max',
            'slug' => 'casing-iphone-12-pro-max',
            'description' => 'Softcase premium anti slip.',
            'condition' => 'new',
            'price' => 200000,
            'weight' => 200,
            'stock' => 50,
        ]);

        ProductImage::create([
            'product_id' => $product2->id,
            'image' => 'casing.jpg',
            'is_thumbnail' => true,
        ]);

        // Varian Produk 2 (Warna-warni)
        ProductVariant::create(['product_id' => $product2->id, 'color' => 'Midnight Blue', 'size' => 'Pro Max', 'price' => 200000, 'stock' => 20]);
        ProductVariant::create(['product_id' => $product2->id, 'color' => 'Red Product', 'size' => 'Pro Max', 'price' => 200000, 'stock' => 15]);
        ProductVariant::create(['product_id' => $product2->id, 'color' => 'Graphite', 'size' => 'Pro Max', 'price' => 210000, 'stock' => 15]);


        // --- PRODUK 3: Asus ROG ---
        $product3 = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $catElektronik->id,
            'name' => 'Asus ROG Strix G15',
            'slug' => 'Asus-ROG-Strix-G15',
            'description' => 'Laptop Gaming untuk pro player.',
            'condition' => 'new',
            'price' => 20000000,
            'weight' => 2500,
            'stock' => 100,
        ]);

        ProductImage::create([
            'product_id' => $product3->id,
            'image' => 'Asus.jpg',
            'is_thumbnail' => true,
        ]);
        
        // Varian Produk 3
        ProductVariant::create(['product_id' => $product3->id, 'color' => 'Eclipse Gray', 'size' => 'RTX 3050', 'price' => 20000000, 'stock' => 50]);
        ProductVariant::create(['product_id' => $product3->id, 'color' => 'Volt Green', 'size' => 'RTX 4060', 'price' => 25000000, 'stock' => 50]);


        // --- PRODUK 4: HP Pavilion ---
        $product4 = Product::create([
            'store_id' => $store->id,
            'product_category_id' => $catElektronik->id,
            'name' => 'HP Pavilion 15',
            'slug' => 'HP-Pavilion-15',
            'description' => 'Laptop Gaming entry level.',
            'condition' => 'new',
            'price' => 11000000,
            'weight' => 2200,
            'stock' => 20,
        ]);

        ProductImage::create([
            'product_id' => $product4->id,
            'image' => 'HP.jpg',
            'is_thumbnail' => true,
        ]);
        
        // Varian Produk 4
        ProductVariant::create(['product_id' => $product4->id, 'color' => 'Silver', 'size' => 'Standard', 'price' => 11000000, 'stock' => 10]);
        ProductVariant::create(['product_id' => $product4->id, 'color' => 'Gold', 'size' => 'Standard', 'price' => 11500000, 'stock' => 10]);
    }
}