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
        // Reset negative balances to 0
        DB::table('store_balances')
            ->where('balance', '<', 0)
            ->update(['balance' => 0]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Cannot revert data correction
    }
};
