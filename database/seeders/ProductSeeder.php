<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductCategory;
use App\Models\Store;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ProductCategory::all();
        $stores = Store::where('is_verified', 1)->get();

        if ($categories->isEmpty() || $stores->isEmpty()) {
            $this->command->error('Kategori atau Store belum ada! Jalankan ProductCategorySeeder dan StoreSeeder terlebih dahulu.');
            return;
        }

        // Dummy products untuk setiap kategori
        $productsData = [
            // KERIPIK
            [
                'category' => 'Keripik',
                'products' => [
                    [
                        'name' => 'Keripik Kentang Original',
                        'description' => 'Keripik kentang dengan rasa original yang renyah dan gurih. Dibuat dari kentang pilihan dengan bumbu berkualitas.',
                        'price' => 15000,
                        'weight' => 150,
                        'stock' => 50,
                    ],
                    [
                        'name' => 'Keripik Singkong Balado',
                        'description' => 'Keripik singkong dengan bumbu balado pedas mantap. Cocok untuk teman santai dan nonton.',
                        'price' => 12000,
                        'weight' => 200,
                        'stock' => 45,
                    ],
                    [
                        'name' => 'Keripik Pisang Cokelat',
                        'description' => 'Keripik pisang premium dengan taburan cokelat manis. Perpaduan sempurna manis dan gurih.',
                        'price' => 18000,
                        'weight' => 180,
                        'stock' => 30,
                    ],
                    [
                        'name' => 'Keripik Tempe Original',
                        'description' => 'Keripik tempe renyah dan gurih, sumber protein nabati yang lezat dan sehat.',
                        'price' => 10000,
                        'weight' => 100,
                        'stock' => 60,
                    ],
                ],
            ],
            // BISKUIT
            [
                'category' => 'Biskuit',
                'products' => [
                    [
                        'name' => 'Biskuit Marie Susu',
                        'description' => 'Biskuit marie klasik dengan kandungan susu tinggi. Cocok untuk sarapan atau cemilan sehat.',
                        'price' => 8000,
                        'weight' => 120,
                        'stock' => 100,
                    ],
                    [
                        'name' => 'Cookies Choco Chips',
                        'description' => 'Cookies premium dengan choco chips berlimpah. Tekstur renyah dengan rasa cokelat yang kaya.',
                        'price' => 25000,
                        'weight' => 200,
                        'stock' => 40,
                    ],
                    [
                        'name' => 'Wafer Vanilla',
                        'description' => 'Wafer berlapis dengan cream vanilla yang lembut dan manis. Favorit keluarga Indonesia.',
                        'price' => 12000,
                        'weight' => 150,
                        'stock' => 80,
                    ],
                    [
                        'name' => 'Biskuit Kelapa Premium',
                        'description' => 'Biskuit dengan taburan kelapa sangrai asli. Aromanya harum dan rasanya gurih manis.',
                        'price' => 15000,
                        'weight' => 180,
                        'stock' => 55,
                    ],
                ],
            ],
            // COKELAT
            [
                'category' => 'Cokelat',
                'products' => [
                    [
                        'name' => 'Cokelat Batang Dark 70%',
                        'description' => 'Cokelat dark premium dengan kakao 70%. Cocok untuk pecinta cokelat pahit dan sehat.',
                        'price' => 35000,
                        'weight' => 100,
                        'stock' => 25,
                    ],
                    [
                        'name' => 'Cokelat Susu Classic',
                        'description' => 'Cokelat susu dengan rasa manis yang pas. Favorit semua kalangan dari anak-anak hingga dewasa.',
                        'price' => 20000,
                        'weight' => 150,
                        'stock' => 70,
                    ],
                    [
                        'name' => 'Cokelat Praline Assorted',
                        'description' => 'Kumpulan praline cokelat dengan berbagai rasa. Cocok untuk hadiah atau koleksi pribadi.',
                        'price' => 50000,
                        'weight' => 250,
                        'stock' => 20,
                    ],
                    [
                        'name' => 'Wafer Cokelat Crispy',
                        'description' => 'Wafer berlapis cokelat dengan tekstur super crispy. Kombinasi sempurna gurih dan manis.',
                        'price' => 18000,
                        'weight' => 180,
                        'stock' => 60,
                    ],
                ],
            ],
            // PERMEN
            [
                'category' => 'Permen',
                'products' => [
                    [
                        'name' => 'Permen Buah Assorted',
                        'description' => 'Permen keras dengan berbagai rasa buah segar. Kemasan praktis untuk dibawa kemana-mana.',
                        'price' => 10000,
                        'weight' => 150,
                        'stock' => 90,
                    ],
                    [
                        'name' => 'Lollipop Rainbow',
                        'description' => 'Lollipop warna-warni dengan rasa buah yang manis. Favorit anak-anak!',
                        'price' => 5000,
                        'weight' => 50,
                        'stock' => 120,
                    ],
                    [
                        'name' => 'Permen Karet Mint',
                        'description' => 'Permen karet dengan sensasi mint yang menyegarkan. Menjaga nafas tetap segar.',
                        'price' => 8000,
                        'weight' => 100,
                        'stock' => 85,
                    ],
                ],
            ],
            // MINUMAN
            [
                'category' => 'Minuman',
                'products' => [
                    [
                        'name' => 'Teh Kotak Jasmine',
                        'description' => 'Teh jasmine dalam kemasan kotak praktis. Rasa teh yang autentik dengan aroma melati.',
                        'price' => 5000,
                        'weight' => 200,
                        'stock' => 150,
                    ],
                    [
                        'name' => 'Kopi Susu Kemasan',
                        'description' => 'Kopi susu siap minum dengan rasa yang nikmat. Praktis untuk menemani aktivitas.',
                        'price' => 6000,
                        'weight' => 200,
                        'stock' => 130,
                    ],
                    [
                        'name' => 'Jus Buah Mix Sachet',
                        'description' => 'Jus buah dalam kemasan sachet praktis. Tinggal seduh dengan air dingin.',
                        'price' => 12000,
                        'weight' => 100,
                        'stock' => 75,
                    ],
                ],
            ],
            // MAKANAN INSTAN
            [
                'category' => 'Makanan Instan',
                'products' => [
                    [
                        'name' => 'Mie Goreng Instan Pedas',
                        'description' => 'Mie goreng dengan bumbu pedas yang mantap. Siap dalam 3 menit!',
                        'price' => 3500,
                        'weight' => 85,
                        'stock' => 200,
                    ],
                    [
                        'name' => 'Mie Kuah Rasa Ayam',
                        'description' => 'Mie kuah dengan kaldu ayam yang gurih. Cocok untuk malam hari yang dingin.',
                        'price' => 3500,
                        'weight' => 75,
                        'stock' => 180,
                    ],
                    [
                        'name' => 'Bubur Ayam Instan',
                        'description' => 'Bubur ayam praktis tinggal seduh. Rasa autentik bubur ayam tradisional.',
                        'price' => 8000,
                        'weight' => 150,
                        'stock' => 95,
                    ],
                    [
                        'name' => 'Cup Noodles Korea',
                        'description' => 'Mie cup dengan rasa khas Korea yang pedas gurih. Favorit anak muda!',
                        'price' => 15000,
                        'weight' => 120,
                        'stock' => 70,
                    ],
                ],
            ],
        ];

        foreach ($productsData as $categoryData) {
            $category = $categories->where('name', $categoryData['category'])->first();
            
            if (!$category) continue;

            foreach ($categoryData['products'] as $index => $productData) {
                // Distribute products across stores
                $store = $stores[$index % $stores->count()];
                
                $product = Product::create([
                    'store_id' => $store->id,
                    'product_category_id' => $category->id,
                    'name' => $productData['name'],
                    'slug' => \Illuminate\Support\Str::slug($productData['name']),
                    'description' => $productData['description'],
                    'condition' => 'new', // Semua snack new
                    'price' => $productData['price'],
                    'weight' => $productData['weight'],
                    'stock' => $productData['stock'],
                ]);

                // Create dummy image (placeholder)
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => "https://via.placeholder.com/400x400/98bad5/ffffff?text=" . urlencode($product->name),
                    'is_thumbnail' => true,
                ]);
            }
        }

        $this->command->info('✅ Berhasil membuat ' . Product::count() . ' produk snack!');
    }
}