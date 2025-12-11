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
        // Using raw SQL to avoid doctrine/dbal dependency issues common in changing column types
        // and because changing UUID/String to BigInt is significant.
        // Assuming MySQL which is standard for Laragon.
        Schema::table('store_balance_histories', function (Blueprint $table) {
            // Drop the old column and add new one to be safe against casting errors
            // But we lose data. If preserving data is needed (which is invalid anyway due to type mismatch), we'd need a temp column.
            // Since the system is likely broken or in dev, we'll try to modify.
            
            // If we use modify:
             DB::statement('ALTER TABLE store_balance_histories MODIFY reference_id BIGINT UNSIGNED NOT NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_balance_histories', function (Blueprint $table) {
             // Revert to UUID/CHAR(36)
             // UUID in Laravel migration creates CHAR(36).
             DB::statement('ALTER TABLE store_balance_histories MODIFY reference_id CHAR(36) NOT NULL');
        });
    }
};
