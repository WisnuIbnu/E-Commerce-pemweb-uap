<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert default product categories
        DB::table('product_categories')->insert([
            [
                'name' => 'Tops',
                'slug' => 'tops',
                'description' => 'Upper body clothing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Bottoms',
                'slug' => 'bottoms',
                'description' => 'Lower body clothing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the default categories
        DB::table('product_categories')
            ->whereIn('name', ['Tops', 'Bottoms'])
            ->delete();
    }
};
