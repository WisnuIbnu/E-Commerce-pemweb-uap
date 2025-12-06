<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class ProductCategorySeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('product_categories')) {
            $this->command->warn('Table product_categories does not exist, skipping ProductCategorySeeder.');
            return;
        }

        $now = Carbon::now();

        $categories = [
            ['image'=>'images/categories/baby-wear.png','name'=>'Baby Wear','slug'=>Str::slug('Baby Wear'),'tagline'=>'Cute & comfy','description'=>'Clothing for newborns and toddlers','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/toys.png','name'=>'Toys','slug'=>Str::slug('Toys'),'tagline'=>'Play & Learn','description'=>'Safe toys for babies','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/accessories.png','name'=>'Accessories','slug'=>Str::slug('Accessories'),'tagline'=>'Finishing touches','description'=>'Hats, socks and more','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/care.png','name'=>'Care & Bath','slug'=>Str::slug('Care & Bath'),'tagline'=>'Gentle care','description'=>'Bath and skincare products for babies','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/shoes.png','name'=>'Shoes','slug'=>Str::slug('Shoes'),'tagline'=>'Tiny steps','description'=>'Soft shoes for baby first steps','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/bags.png','name'=>'Bags','slug'=>Str::slug('Bags'),'tagline'=>'Carry with style','description'=>'Diaper bags & small carriers','created_at'=>$now,'updated_at'=>$now],
        ];

        DB::table('product_categories')->insert($categories);
        $this->command->info('Inserted product_categories.');
    }
}
