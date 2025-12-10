<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel stok per-size
        Schema::create('product_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->string('size', 10);  // contoh: "36", "40", "42.5"
            $table->integer('stock')->default(0);

            $table->timestamps();

            $table->unique(['product_id', 'size']);
        });

        // Hapus kolom JSON lama "sizes" kalau sebelumnya sudah dibuat
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'sizes')) {
                $table->dropColumn('sizes');
            }
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_sizes');
    }
};
