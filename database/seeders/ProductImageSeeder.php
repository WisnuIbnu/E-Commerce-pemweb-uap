<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Gambar sepatu menggunakan placeholder yang reliable
        $productImages = [
            'air-max-classic-white' => [
                'https://placehold.co/600x750/ffffff/000000?text=Air+Max+White',
            ],
            'urban-black-sneakers' => [
                'https://placehold.co/600x750/1a1a1a/ffffff?text=Urban+Black',
            ],
            'retro-blue-runners' => [
                'https://placehold.co/600x750/60A5FA/ffffff?text=Retro+Blue',
            ],
            'pro-runner-3000' => [
                'https://placehold.co/600x750/93C5FD/1E3A8A?text=Pro+Runner',
            ],
            'speed-boost-elite' => [
                'https://placehold.co/600x750/1E3A8A/93C5FD?text=Speed+Boost',
            ],
            'classic-brown-loafers' => [
                'https://placehold.co/600x750/8B4513/ffffff?text=Brown+Loafers',
            ],
            'navy-suede-loafers' => [
                'https://placehold.co/600x750/000080/ffffff?text=Navy+Loafers',
            ],
            'mountain-hiker-boots' => [
                'https://placehold.co/600x750/556B2F/ffffff?text=Hiker+Boots',
            ],
            'chelsea-ankle-boots' => [
                'https://placehold.co/600x750/654321/ffffff?text=Chelsea+Boots',
            ],
            'beach-sandals' => [
                'https://placehold.co/600x750/FFD700/000000?text=Beach+Sandals',
            ],
            'sport-slide-sandals' => [
                'https://placehold.co/600x750/00CED1/000000?text=Sport+Slides',
            ],
        ];

        foreach ($productImages as $slug => $images) {
            $product = Product::where('slug', $slug)->first();
            
            if ($product) {
                foreach ($images as $imageUrl) {
                    ProductImage::updateOrCreate(
                        [
                            'product_id' => $product->id,
                            'image' => $imageUrl
                        ],
                        [
                            'product_id' => $product->id,
                            'image' => $imageUrl
                        ]
                    );
                }
            }
        }

        $this->command->info('✓ Product images added successfully!');
    }
}
