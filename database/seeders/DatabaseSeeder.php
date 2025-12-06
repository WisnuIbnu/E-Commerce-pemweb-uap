<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin SORAE',
            'email' => 'admin@sorae.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
        
        // Create Seller
        User::create([
            'name' => 'Seller Demo',
            'email' => 'seller@sorae.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);
        
        // Create Buyer
        User::create([
            'name' => 'Buyer Demo',
            'email' => 'buyer@sorae.com',
            'password' => Hash::make('password'),
            'role' => 'buyer',
        ]);
        
        // Create Categories
        $categories = [
            ['name' => 'Women Fashion', 'slug' => 'women-fashion'],
            ['name' => 'Men Fashion', 'slug' => 'men-fashion'],
            ['name' => 'Accessories', 'slug' => 'accessories'],
            ['name' => 'Shoes', 'slug' => 'shoes'],
            ['name' => 'Bags', 'slug' => 'bags'],
        ];
        
        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}