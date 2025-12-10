<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('product_sizes', function (Blueprint $table) {
            // 1. Drop foreign key dulu (biasanya namanya product_sizes_product_id_foreign)
            $table->dropForeign(['product_id']);

            // 2. Drop unique lama (product_id + size)
            $table->dropUnique('product_sizes_product_id_size_unique');

            // 3. Tambah unique baru: product_id + color + size
            $table->unique(['product_id', 'color', 'size'], 'product_color_size_unique');

            // 4. Balikin lagi foreign key product_id ke products.id
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('product_sizes', function (Blueprint $table) {
            // Balikkin untuk rollback

            // 1. Drop foreign key yang barusan kita buat ulang
            $table->dropForeign(['product_id']);

            // 2. Drop unique baru
            $table->dropUnique('product_color_size_unique');

            // 3. Balik ke unique lama (product_id + size)
            $table->unique(['product_id', 'size'], 'product_sizes_product_id_size_unique');

            // 4. Re-create foreign key seperti semula
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
        });
    }
};
