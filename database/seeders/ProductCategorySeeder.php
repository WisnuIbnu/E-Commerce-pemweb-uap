<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan FK
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('product_categories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // ==========================
        // MAIN CATEGORIES
        // ==========================
        $mainCategories = [
            ['name' => 'Cake', 'tagline' => 'Aneka cake lezat', 'description' => 'Kumpulan cake premium'],
            ['name' => 'Pastry', 'tagline' => 'Pastry renyah & fresh', 'description' => 'Croissant & pastry'],
            ['name' => 'Donuts', 'tagline' => 'Donat empuk', 'description' => 'Aneka donat premium'],
            ['name' => 'Ice Cream', 'tagline' => 'Es krim lembut', 'description' => 'Gelato dan ice cream'],
            ['name' => 'Pudding', 'tagline' => 'Pudding lembut', 'description' => 'Pudding berbagai rasa'],
            ['name' => 'Dessert Box', 'tagline' => 'Dessert kekinian', 'description' => 'Dessert dalam box']
        ];

        $categoryIds = [];

        foreach ($mainCategories as $index => $cat) {
            $imageNumber = $index + 1;

            $id = DB::table('product_categories')->insertGetId([
                'parent_id'  => null,
                'image'      => 'categories/' . $imageNumber . '.png',
                'name'       => $cat['name'],
                'slug'       => Str::slug($cat['name']),
                'tagline'    => $cat['tagline'],
                'description'=> $cat['description'],
            ]);

            $categoryIds[$cat['name']] = $id;
        }

        // ==========================
        // SUB CATEGORIES
        // ==========================
        $subCategories = [
            ['parent' => 'Cake', 'name' => 'Chocolate Cake'],
            ['parent' => 'Cake', 'name' => 'Cheesecake'],
            ['parent' => 'Cake', 'name' => 'Fruit Cake'],
            ['parent' => 'Pastry', 'name' => 'Croissant'],
            ['parent' => 'Pastry', 'name' => 'Danish Pastry'],
            ['parent' => 'Donuts', 'name' => 'Bomboloni'],
            ['parent' => 'Donuts', 'name' => 'Ring Donut'],
            ['parent' => 'Ice Cream', 'name' => 'Gelato'],
            ['parent' => 'Pudding', 'name' => 'Pudding Coklat'],
            ['parent' => 'Dessert Box', 'name' => 'Tiramisu Box'],
        ];

        foreach ($subCategories as $i => $sub) {
            $imageNumber = 7 + $i; // Mulai dari 7.png

            DB::table('product_categories')->insert([
                'parent_id'   => $categoryIds[$sub['parent']],
                'image'       => 'categories/' . $imageNumber . '.png',
                'name'        => $sub['name'],
                'slug'        => Str::slug($sub['name']),
                'tagline'     => $sub['name'],
                'description' => $sub['name'] . ' premium'
            ]);
        }
    }
}