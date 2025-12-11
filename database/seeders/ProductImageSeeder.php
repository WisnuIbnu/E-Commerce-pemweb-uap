<?php

namespace Database\Seeders;

use App\Models\ProductImage;
use Illuminate\Database\Seeder;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        $images = [
            ['id' => 81, 'product_id' => 41, 'image' => '/images/yeti-rambler-30oz-tumbler.jpg', 'is_thumbnail' => 1],
            ['id' => 82, 'product_id' => 42, 'image' => '/images/yeti-rambler-20oz-stainless.jpg', 'is_thumbnail' => 1],
            ['id' => 83, 'product_id' => 43, 'image' => '/images/yeti-rambler-10oz-lowball.jpg', 'is_thumbnail' => 1],
            ['id' => 84, 'product_id' => 44, 'image' => '/images/yeti-rambler-26oz-bottle.jpg', 'is_thumbnail' => 1],
            ['id' => 85, 'product_id' => 45, 'image' => '/images/yeti-rambler-14oz-mug.jpg', 'is_thumbnail' => 1],
            ['id' => 86, 'product_id' => 46, 'image' => '/images/hydroflask-32oz-wide-mouth.jpg', 'is_thumbnail' => 1],
            ['id' => 87, 'product_id' => 47, 'image' => '/images/hydroflask-24oz-standard-mouth.jpg', 'is_thumbnail' => 1],
            ['id' => 88, 'product_id' => 48, 'image' => '/images/hydroflask-20oz-tumbler.jpg', 'is_thumbnail' => 1],
            ['id' => 89, 'product_id' => 49, 'image' => '/images/hydroflask-40oz-straw-lid.jpg', 'is_thumbnail' => 1],
            ['id' => 90, 'product_id' => 50, 'image' => '/images/hydroflask-12oz-coffee-mug.jpg', 'is_thumbnail' => 1],
            ['id' => 91, 'product_id' => 51, 'image' => '/images/stanley-quencher-40oz.jpg', 'is_thumbnail' => 1],
            ['id' => 92, 'product_id' => 52, 'image' => '/images/stanley-classic-16oz-mug.jpg', 'is_thumbnail' => 1],
            ['id' => 93, 'product_id' => 53, 'image' => '/images/stanley-adventure-30oz.jpg', 'is_thumbnail' => 1],
            ['id' => 94, 'product_id' => 54, 'image' => '/images/stanley-iceflow-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 95, 'product_id' => 55, 'image' => '/images/stanley-classic-bottle-1qt.jpg', 'is_thumbnail' => 1],
            ['id' => 96, 'product_id' => 56, 'image' => '/images/contigo-autoseal-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 97, 'product_id' => 57, 'image' => '/images/contigo-snapseal-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 98, 'product_id' => 58, 'image' => '/images/contigo-luxe-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 99, 'product_id' => 59, 'image' => '/images/contigo-jackson-24oz.jpg', 'is_thumbnail' => 1],
            ['id' => 100, 'product_id' => 60, 'image' => '/images/contigo-pinnacle-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 101, 'product_id' => 61, 'image' => '/images/klean-kanteen-27oz-wide.jpg', 'is_thumbnail' => 1],
            ['id' => 102, 'product_id' => 62, 'image' => '/images/klean-kanteen-tkwide-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 103, 'product_id' => 63, 'image' => '/images/klean-kanteen-tkpro-25oz.jpg', 'is_thumbnail' => 1],
            ['id' => 104, 'product_id' => 64, 'image' => '/images/klean-kanteen-kid-12oz.jpg', 'is_thumbnail' => 1],
            ['id' => 105, 'product_id' => 65, 'image' => '/images/klean-kanteen-rise-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 106, 'product_id' => 66, 'image' => '/images/thermos-king-24oz.jpg', 'is_thumbnail' => 1],
            ['id' => 107, 'product_id' => 67, 'image' => '/images/thermos-guardian-18oz.jpg', 'is_thumbnail' => 1],
            ['id' => 108, 'product_id' => 68, 'image' => '/images/thermos-sipp-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 109, 'product_id' => 69, 'image' => '/images/thermos-funtainer-12oz.jpg', 'is_thumbnail' => 1],
            ['id' => 110, 'product_id' => 70, 'image' => '/images/thermos-element5-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 111, 'product_id' => 71, 'image' => '/images/swell-stone-17oz.jpg', 'is_thumbnail' => 1],
            ['id' => 112, 'product_id' => 72, 'image' => '/images/swell-traveler-20oz.jpg', 'is_thumbnail' => 1],
            ['id' => 113, 'product_id' => 73, 'image' => '/images/swell-original-25oz.jpg', 'is_thumbnail' => 1],
            ['id' => 114, 'product_id' => 74, 'image' => '/images/swell-roamer-40oz.jpg', 'is_thumbnail' => 1],
            ['id' => 115, 'product_id' => 75, 'image' => '/images/swell-tumbler-18oz.jpg', 'is_thumbnail' => 1],
            ['id' => 116, 'product_id' => 76, 'image' => '/images/zojirushi-sm-sa48-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 117, 'product_id' => 77, 'image' => '/images/zojirushi-sm-khe48-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 118, 'product_id' => 78, 'image' => '/images/zojirushi-food-jar-13oz.jpg', 'is_thumbnail' => 1],
            ['id' => 119, 'product_id' => 79, 'image' => '/images/zojirushi-sm-sc48-16oz.jpg', 'is_thumbnail' => 1],
            ['id' => 120, 'product_id' => 80, 'image' => '/images/zojirushi-food-jar-10oz.jpg', 'is_thumbnail' => 1],
            ['id' => 121, 'product_id' => 81, 'image' => 'images/stores/australia.jpg', 'is_thumbnail' => 1],
            ['id' => 122, 'product_id' => 82, 'image' => 'images/stores/universal.jpg', 'is_thumbnail' => 1],
            ['id' => 123, 'product_id' => 83, 'image' => 'images/stores/helokiti.jpg', 'is_thumbnail' => 1],
        ];

        foreach ($images as $image) {
            ProductImage::updateOrCreate(
                ['id' => $image['id']],
                $image
            );
        }
    }
}