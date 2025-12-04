<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // matikan foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // kosongkan tabel
        DB::table('product_categories')->truncate();

        // aktifkan lagi foreign key
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Kategori utama
        $mainCategories = [
            ['name' => 'Cake', 'tagline' => 'Aneka cake lezat', 'description' => 'Kumpulan cake premium'],
            ['name' => 'Pastry', 'tagline' => 'Pastry renyah & fresh', 'description' => 'Croissant & pastry'],
            ['name' => 'Donuts', 'tagline' => 'Donat empuk', 'description' => 'Aneka donat premium'],
            ['name' => 'Ice Cream', 'tagline' => 'Es krim lembut', 'description' => 'Gelato dan ice cream'],
            ['name' => 'Pudding', 'tagline' => 'Pudding lembut', 'description' => 'Pudding berbagai rasa'],
            ['name' => 'Dessert Box', 'tagline' => 'Dessert kekinian', 'description' => 'Dessert dalam box']
        ];

        $categoryIds = [];

        foreach ($mainCategories as $cat) {
            $id = DB::table('product_categories')->insertGetId([
                'parent_id' => null,
                'image' => null,
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'tagline' => $cat['tagline'],
                'description' => $cat['description'],
            ]);

            $categoryIds[$cat['name']] = $id;
        }

        // Subkategori
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

        foreach ($subCategories as $sub) {
            DB::table('product_categories')->insert([
                'parent_id' => $categoryIds[$sub['parent']],
                'image' => null,
                'name' => $sub['name'],
                'slug' => Str::slug($sub['name']),
                'tagline' => $sub['name'],
                'description' => $sub['name'] . ' premium'
            ]);
        }
    }
}