<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;

class BuyerSeeder extends Seeder
{
    public function run()
    {
        if (! Schema::hasTable('buyers') || ! Schema::hasTable('users')) {
            $this->command->warn('Skipping BuyerSeeder: buyers or users table missing.');
            return;
        }

        $now = Carbon::now();

        // jika sudah ada buyer, skip
        if (DB::table('buyers')->count() > 0) {
            $this->command->info('Buyers already exist, skipping BuyerSeeder.');
            return;
        }

        // gunakan beberapa user yang ada, atau buat buyer for first user
        $userIds = DB::table('users')->pluck('id')->take(3)->toArray();
        if (empty($userIds)) {
            $this->command->warn('No users found. Create users first or run User seeder.');
            return;
        }

        $buyers = [];
        foreach ($userIds as $uid) {
            $buyers[] = [
                'user_id' => $uid,
                'profile_picture' => null,
                'phone_number' => '0812' . rand(1000000, 9999999),
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        DB::table('buyers')->insert($buyers);
        $this->command->info('Inserted buyers.');
    }
}
