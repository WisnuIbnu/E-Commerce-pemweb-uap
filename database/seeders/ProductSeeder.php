<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\ProductCategory;

class ProductSeeder extends Seeder
{
    public function run()
    {
        echo "\n[ProductSeeder] Running...\n";

        $category = ProductCategory::first();

        if (!$category) {
            echo "[ProductSeeder] NO CATEGORY FOUND!\n";
            return;
        }

        $categoryId = $category->id;

        $products = [
            [
                'store_id' => 1,
                'name' => 'Cupcake Vanilla Buttercream',
                'price' => 47359,
                'stock' => 16,
                'weight' => 250,
                'condition' => 'new',
                'description' => 'Cupcake vanilla dengan buttercream lembut.',
            ],
            [
                'store_id' => 1,
                'name' => 'Macaron Strawberry',
                'price' => 25500,
                'stock' => 32,
                'weight' => 100,
                'condition' => 'new',
                'description' => 'Macaron rasa stroberi premium.',
            ],
            [
                'store_id' => 2,
                'name' => 'Cupcake Red Velvet',
                'price' => 38000,
                'stock' => 20,
                'weight' => 300,
                'condition' => 'new',
                'description' => 'Cupcake red velvet lembut dan manis.',
            ],
            [
                'store_id' => 3,
                'name' => 'Brownies Coklat Premium',
                'price' => 52000,
                'stock' => 15,
                'weight' => 500,
                'condition' => 'new',
                'description' => 'Brownies coklat legit, bestseller!',
            ],
        ];

        foreach ($products as $p) {
            Product::create([
                'store_id' => $p['store_id'],
                'product_category_id' => $categoryId,
                'name' => $p['name'],
                'slug' => Str::slug($p['name']),
                'price' => $p['price'],
                'stock' => $p['stock'],
                'weight' => $p['weight'],
                'condition' => $p['condition'],
                'description' => $p['description'],
            ]);
        }

        echo "[ProductSeeder] Products inserted!\n";
    }
}
