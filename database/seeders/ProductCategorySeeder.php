<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Tops', 'description' => 'Upper body clothing'],
            ['name' => 'Bottoms', 'description' => 'Lower body clothing'],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
