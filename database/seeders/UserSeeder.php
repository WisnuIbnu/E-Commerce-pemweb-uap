<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@ecommerce.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Member/Customer User
        User::create([
            'name' => 'IrvanTur',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        // Seller User (akan punya toko)
        User::create([
            'name' => 'Dimaz Sparepart',
            'email' => 'seller@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
            'email_verified_at' => now(),
        ]);

        echo "✅ Users created successfully!\n";
        echo "📧 Admin: admin@ecommerce.com | password\n";
        echo "📧 Customer: customer@example.com | password\n";
        echo "📧 Seller: seller@example.com | password\n";
    }
}
