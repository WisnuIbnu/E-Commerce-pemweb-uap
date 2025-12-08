<?php

namespace Database\Seeders;

use App\Models\Buyer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::updateOrCreate(
            ['email' => 'buyer@example.com'],
            [
                'name' => 'Buyer User',
                'password' => Hash::make('password'),
                'role' => 'member',
            ]
        );

        Buyer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone_number' => '081234567890',
                // Add other fields if necessary
            ]
        );

        $this->command->info('Buyer User created: buyer@example.com / password');
    }
}
