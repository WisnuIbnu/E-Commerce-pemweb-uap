<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Mesin Cuci',
            'Kulkas',
            'Televisi',
            'AC / Pendingin',
            'Laptop',
            'Handphone',
            'Kamera',
            'Speaker',
        ];

        foreach ($categories as $name) {
            ProductCategory::create([
                'name' => $name,
                'slug' => \Str::slug($name),
                'tagline' => null,
                'description' => null,
                'parent_id' => null,
                'image' => null,
            ]);
        }
    }
}
