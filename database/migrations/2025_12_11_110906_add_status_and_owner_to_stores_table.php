<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Tambah kolom owner_id hanya jika belum ada
            if (!Schema::hasColumn('stores', 'owner_id')) {
                $table->unsignedBigInteger('owner_id')
                      ->nullable()
                      ->after('id');

                $table->foreign('owner_id')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade');
            }

            // Tambah kolom status hanya jika belum ada
            if (!Schema::hasColumn('stores', 'status')) {
                $table->string('status')
                      ->default('pending')
                      ->after('owner_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            if (Schema::hasColumn('stores', 'owner_id')) {
                $table->dropForeign(['owner_id']);
                $table->dropColumn('owner_id');
            }

            if (Schema::hasColumn('stores', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
