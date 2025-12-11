<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class StoreSeeder extends Seeder
{
    public function run()
    {
        if (!Schema::hasTable('stores')) {
            $this->command->warn('❌ Table stores does not exist, skipping StoreSeeder.');
            return;
        }

        if (!Schema::hasTable('users')) {
            $this->command->warn('❌ Table users does not exist. Create users first.');
            return;
        }

        // Ambil user pertama (atau buat 1 user dummy jika belum ada)
        $userId = DB::table('users')->value('id');

        if (!$userId) {
            $userId = DB::table('users')->insertGetId([
                'name' => 'Default Seller',
                'email' => 'seller@example.com',
                'password' => bcrypt('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        // Jangan insert duplicate store
        if (DB::table('stores')->count() > 0) {
            $this->command->info('ℹ️ Store already exists. Skipping StoreSeeder.');
            return;
        }

        DB::table('stores')->insert([
            'user_id' => $userId,
            'name' => 'BabyKo Official Store',
            'logo' => 'public/images/store/logo-babyko.jpeg',
            'about' => 'Toko resmi Puffy Baby – menyediakan kebutuhan bayi terbaik dan berkualitas.',
            'phone' => '081234567890',
            'address_id' => Str::uuid(),
            'city' => 'Jakarta',
            'address' => 'Jl. Mawar No. 123, Jakarta Selatan',
            'postal_code' => '12345',
            'is_verified' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        $this->command->info('✅ StoreSeeder completed — Store created successfully!');
    }
}
