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
            ['image'=>'images/categories/babywear.jpeg','name'=>'Baby Wear','slug'=>Str::slug('Baby Wear'),'tagline'=>'Cute & comfy','description'=>'Clothing for newborns and toddlers','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/toys.jpeg','name'=>'Toys','slug'=>Str::slug('Toys'),'tagline'=>'Play & Learn','description'=>'Safe toys for babies','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/accessories.jpeg','name'=>'Accessories','slug'=>Str::slug('Accessories'),'tagline'=>'Finishing touches','description'=>'Hats, socks and more','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/bath&care.jpeg','name'=>'Care & Bath','slug'=>Str::slug('Care & Bath'),'tagline'=>'Gentle care','description'=>'Bath and skincare products for babies','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/shoes.jpeg','name'=>'Shoes','slug'=>Str::slug('Shoes'),'tagline'=>'Tiny steps','description'=>'Soft shoes for baby first steps','created_at'=>$now,'updated_at'=>$now],
            ['image'=>'images/categories/bag.jpeg','name'=>'Bags','slug'=>Str::slug('Bags'),'tagline'=>'Carry with style','description'=>'Diaper bags & small carriers','created_at'=>$now,'updated_at'=>$now],
        ];

        DB::table('product_categories')->insert($categories);
        $this->command->info('Inserted product_categories.');
    }
}
