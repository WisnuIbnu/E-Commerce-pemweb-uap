<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BuyerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            // Create or update user buyer
            $buyerUser = User::updateOrCreate(
                ['email' => 'buyer@example.com'],
                [
                    'name' => 'Buyer User',
                    'password' => Hash::make('password'),
                    'role' => 'member'
                ]
            );

            $this->command->info('✓ Buyer user created: ' . $buyerUser->email);

            // Create or update buyer profile
            $buyer = Buyer::updateOrCreate(
                ['user_id' => $buyerUser->id],
                [
                    'profile_picture' => null,
                    'phone_number' => '081234567890',
                ]
            );

            $this->command->info('✓ Buyer profile created for: ' . $buyerUser->name);
            $this->command->info('');
            $this->command->info('Buyer Login Credentials:');
            $this->command->info('Email: buyer@example.com');
            $this->command->info('Password: password');
        });
    }
}
