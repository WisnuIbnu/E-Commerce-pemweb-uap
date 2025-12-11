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
        $store = Store::first();
        if (! $store) return;

        $categories = ProductCategory::where('store_id', $store->id)->get()->keyBy('name');

        $products = [
            [
                'name' => 'Beras Ramos 5kg',
                'category' => 'Sembako',
                'price' => 65000,
                'weight' => 5000,
                'stock' => 50,
                'condition' => 'new',
                'description' => 'Beras Ramos kualitas medium, 5kg.',
            ],
            [
                'name' => 'Minyak Goreng 1L',
                'category' => 'Sembako',
                'price' => 17000,
                'weight' => 1000,
                'stock' => 100,
                'condition' => 'new',
                'description' => 'Minyak goreng sawit kemasan 1L.',
            ],
            [
                'name' => 'Gula Pasir 1kg',
                'category' => 'Sembako',
                'price' => 15000,
                'weight' => 1000,
                'stock' => 80,
                'condition' => 'new',
                'description' => 'Gula pasir putih 1kg.',
            ],
            [
                'name' => 'Telur Ayam 1kg',
                'category' => 'Sembako',
                'price' => 27000,
                'weight' => 1000,
                'stock' => 60,
                'condition' => 'new',
                'description' => 'Telur ayam segar per kilo.',
            ],
        ];

        foreach ($products as $item) {
            $category = $categories[$item['category']] ?? null;
            if (! $category) continue;

            Product::updateOrCreate(
                [
                    'name' => $item['name'],
                    'store_id' => $store->id,
                ],
                [
                    'slug' => Str::slug($item['name']),
                    'product_category_id' => $category->id,
                    'description' => $item['description'],
                    'price' => $item['price'],
                    'weight' => $item['weight'],
                    'stock' => $item['stock'],
                    'condition' => $item['condition'],
                ]
            );
        }
    }
}
