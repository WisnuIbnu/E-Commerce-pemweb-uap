<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin2@example.com'], // Cek berdasarkan email
            [
                'name' => 'Second Admin',
                'password' => Hash::make('password123'), // Ganti password sesuai kebutuhan
                'role' => 'admin',
            ]
        );
    }
}
