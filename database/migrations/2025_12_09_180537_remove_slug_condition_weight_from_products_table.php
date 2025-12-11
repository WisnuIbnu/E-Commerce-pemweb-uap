<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveSlugConditionWeightFromProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menghapus kolom yang tidak diperlukan
            $table->dropColumn(['slug', 'condition', 'weight']);
        });
    }

    /**
     * Reverse the migrations (untuk rollback).
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Menambahkan kembali kolom yang dihapus jika rollback
            $table->string('slug')->nullable();
            $table->string('condition')->nullable();
            $table->integer('weight')->nullable();
        });
    }
}
