<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'superadmin@tumbler.com'],
            [
                'name' => 'Super Admin',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Buat Akun Member (seller & buyer)
        User::updateOrCreate(
            ['email' => 'jaehyun@gmail.com'],
            [
                'name' => 'Jaehyun',
                'role' => 'member',
                'password' => Hash::make('halo12345'),
            ]
        );

        // John Doe - Premium Store
        User::updateOrCreate(
            ['email' => 'john@premiumtumbler.com'],
            [
                'name' => 'John Doe - Premium Store',
                'role' => 'member',
                'password' => Hash::make('password'),
            ]
        );

        // Sarah Smith - Elite Shop
        User::updateOrCreate(
            ['email' => 'sarah@elitetumbler.com'],
            [
                'name' => 'Sarah Smith - Elite Shop',
                'role' => 'member',
                'password' => Hash::make('password'),
            ]
        );
    }
}
