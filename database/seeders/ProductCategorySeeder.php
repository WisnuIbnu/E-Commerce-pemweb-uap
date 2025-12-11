<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;
use Illuminate\Support\Str;

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

        foreach ($categories as $category) {
            ProductCategory::firstOrCreate(
                ['name' => $category],
                [
                    'slug' => Str::slug($category),
                    'parent_id' => null,
                    'image' => 'default.png', // bisa pakai placeholder
                    'tagline' => 'Kategori ' . $category,
                    'description' => 'No description', // wajib diisi
                ]
            );
        }
    }
}
