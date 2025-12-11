<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();
        if (! $store) return;

        $categories = [
            [
                'name' => 'Sembako',
                'description' => 'Kebutuhan pokok sehari-hari.',
            ],
            [
                'name' => 'Bumbu Dapur',
                'description' => 'Aneka bumbu untuk memasak.',
            ],
            [
                'name' => 'Minuman',
                'description' => 'Minuman kemasan dan instan.',
            ],
        ];

        foreach ($categories as $cat) {
            ProductCategory::updateOrCreate(
                [
                    'name' => $cat['name'],
                    'store_id' => $store->id,
                ],
                [
                    'slug' => Str::slug($cat['name']),
                    'description' => $cat['description'],
                ]
            );
        }
    }
}
