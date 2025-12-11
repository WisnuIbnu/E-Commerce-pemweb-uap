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
        // 1. Set user ID 1 sebagai admin
        User::where('id', 1)->update([
            'role' => 'admin'
        ]);

        // 2. (OPSIONAL) Buat admin baru jika mau
        User::create([
<<<<<<< HEAD
            'name' => 'Second Admin',
            'email' => 'admin2@example.com',
=======
            'name' => 'Admin Sucipto',
            'email' => 'sucipto@example.com',
>>>>>>> 248a66fdfc86b0ed23ff66b8e186e1e5f0defc26
            'password' => Hash::make('password123'),
            'role' => 'admin'
        ]);
    }
}
