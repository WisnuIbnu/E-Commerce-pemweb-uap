<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        echo "\n🌱 Starting database seeding...\n\n";

        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            StoreSeeder::class,
            ProductSeeder::class,
        ]);

        echo "\n✅ Database seeding completed!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "📧 LOGIN CREDENTIALS:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "Admin:\n";
        echo "  Email: admin@ecommerce.com\n";
        echo "  Pass:  password\n\n";
        echo "Customer:\n";
        echo "  Email: customer@example.com\n";
        echo "  Pass:  password\n\n";
        echo "Seller:\n";
        echo "  Email: seller@example.com\n";
        echo "  Pass:  password\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    }
}
