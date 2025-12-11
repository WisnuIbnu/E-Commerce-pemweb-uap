<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Kalau dulu pernah ada foreign key user_id, hapus dulu FKn-nya
            // Kalau tidak ada, baris dropForeign ini bisa kamu comment/hapus.
            if (Schema::hasColumn('stores', 'user_id')) {
                $table->dropForeign(['user_id']);          // nama default: stores_user_id_foreign
                $table->dropColumn('user_id');
            }

            // Kalau kolom is_verified sudah tidak dipakai, sekalian hapus
            if (Schema::hasColumn('stores', 'is_verified')) {
                $table->dropColumn('is_verified');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();

            $table->boolean('is_verified')->default(false);
        });
    }
};
