<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Keripik',
                'slug' => 'keripik',
                'image' => '🍟',
                'tagline' => 'Berbagai macam keripik renyah',
                'description' => 'Keripik kentang, singkong, tempe, pisang, dan lainnya',
            ],
            [
                'name' => 'Biskuit',
                'slug' => 'biskuit',
                'image' => '🍪',
                'tagline' => 'Biskuit dan cookies favorit',
                'description' => 'Berbagai jenis biskuit manis, gurih, dan cookies premium',
            ],
            [
                'name' => 'Cokelat',
                'slug' => 'cokelat',
                'image' => '🍫',
                'tagline' => 'Cokelat premium untuk semua',
                'description' => 'Cokelat batangan, praline, truffle, dan wafer cokelat',
            ],
            [
                'name' => 'Permen',
                'slug' => 'permen',
                'image' => '🍬',
                'tagline' => 'Permen manis untuk Anda',
                'description' => 'Permen keras, lunak, permen karet, dan lollipop',
            ],
            [
                'name' => 'Minuman',
                'slug' => 'minuman',
                'image' => '🥤',
                'tagline' => 'Minuman segar dan nikmat',
                'description' => 'Minuman kemasan, serbuk, teh, kopi, dan jus',
            ],
            [
                'name' => 'Makanan Instan',
                'slug' => 'makanan-instan',
                'image' => '🍜',
                'tagline' => 'Praktis dan lezat',
                'description' => 'Mie instan, sup instan, bubur, dan makanan siap saji',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}