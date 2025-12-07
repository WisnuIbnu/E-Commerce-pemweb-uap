<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'tagline' => 'Latest gadgets and devices',
                'description' => 'Find the latest electronics including phones, laptops, and accessories.',
            ],
            [
                'name' => 'Fashion',
                'tagline' => 'Trendy clothing and accessories',
                'description' => 'Discover the latest fashion trends for men and women.',
            ],
            [
                'name' => 'Home & Living',
                'tagline' => 'Make your house a home',
                'description' => 'Furniture, decor, and home essentials.',
            ],
            [
                'name' => 'Sports & Outdoor',
                'tagline' => 'Gear up for adventure',
                'description' => 'Sports equipment and outdoor gear.',
            ],
            [
                'name' => 'Books & Stationery',
                'tagline' => 'Feed your mind',
                'description' => 'Books, notebooks, and office supplies.',
            ],
            [
                'name' => 'Beauty & Health',
                'tagline' => 'Look good, feel great',
                'description' => 'Skincare, makeup, and health products.',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create([
                'parent_id' => null,
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'tagline' => $category['tagline'],
                'description' => $category['description'],
            ]);
        }

        echo "✅ Categories created successfully!\n";
    }
}
