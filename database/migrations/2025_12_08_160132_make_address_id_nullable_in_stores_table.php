<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Mengubah kolom 'address_id' menjadi nullable
            $table->string('address_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Mengembalikan kolom 'address_id' ke bentuk semula tanpa nullable
            $table->string('address_id')->nullable(false)->change();
        });
    }
};
