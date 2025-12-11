<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name' => 'YETI',
                'slug' => 'yeti',
                'tagline' => 'Built for the Wild',
                'description' => 'Premium outdoor drinkware dengan insulasi terbaik untuk petualangan ekstrem',
                'image' => 'categories/yeti.jpg',
            ],
            [
                'id' => 2,
                'name' => 'Hydro Flask',
                'slug' => 'hydro-flask',
                'tagline' => 'Keeps Cold 24 Hours',
                'description' => 'Tumbler dengan teknologi TempShield insulasi ganda',
                'image' => 'categories/hydroflask.jpg',
            ],
            [
                'id' => 3,
                'name' => 'Stanley',
                'slug' => 'stanley',
                'tagline' => 'Built For Life',
                'description' => 'Legendary drinkware sejak 1913, tahan lama dan stylish',
                'image' => 'categories/stanley.jpg',
            ],
            [
                'id' => 4,
                'name' => 'Contigo',
                'slug' => 'contigo',
                'tagline' => 'Spill-Proof Technology',
                'description' => 'Tumbler dengan teknologi AUTOSEAL anti tumpah',
                'image' => 'categories/contigo.jpg',
            ],
            [
                'id' => 5,
                'name' => 'Klean Kanteen',
                'slug' => 'klean-kanteen',
                'tagline' => 'For a Cleaner Planet',
                'description' => 'Eco-friendly stainless steel bottles tanpa BPA',
                'image' => 'categories/kleankanteen.jpg',
            ],
            [
                'id' => 6,
                'name' => 'Thermos',
                'slug' => 'thermos',
                'tagline' => 'Keeping it Hot, Cold, Fresh',
                'description' => 'Pioneer teknologi vacuum insulation sejak 1904',
                'image' => 'categories/thermos.jpg',
            ],
            [
                'id' => 7,
                'name' => 'S\'well',
                'slug' => 'swell',
                'tagline' => 'Fashion Meets Function',
                'description' => 'Designer drinkware dengan desain eksklusif',
                'image' => 'categories/swell.jpg',
            ],
            [
                'id' => 8,
                'name' => 'Zojirushi',
                'slug' => 'zojirushi',
                'tagline' => 'Japanese Quality',
                'description' => 'Teknologi Jepang untuk menjaga suhu sempurna',
                'image' => 'categories/zojirushi.jpg',
            ],
            [
                'id' => 9,
                'name' => 'Tupperware',
                'slug' => 'tupperware',
                'tagline' => 'From Australia',
                'description' => 'australia lah pokoknya',
                'image' => 'categories/tupperware.jpg',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate(
                ['id' => $category['id']],
                $category
            );
        }
    }
}