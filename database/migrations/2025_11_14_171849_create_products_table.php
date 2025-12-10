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
        Schema::create('products', function (Blueprint $table) {
            $table->id()->primary();
            
            // Relasi
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            
            // Kita ubah namanya menjadi product_category_id agar sinkron dengan Model dan Seeder
            $table->foreignId('product_category_id')->constrained('product_categories')->cascadeOnDelete();
            
            $table->string('name');
            $table->string('slug')->unique();
            
            // PERBAIKAN 2: Tambahkan kolom thumbnail
            $table->string('thumbnail'); 
            
            // PERBAIKAN 3: Ubah 'description' jadi 'about'
            $table->longText('about'); 
            
            $table->decimal('price', 26, 2);
            $table->integer('stock');
            
            // Opsional (Bisa ditambahkan nanti ke form, kita buat nullable/default dulu agar tidak error)
            $table->integer('weight')->default(1000); 
            $table->enum('condition', ['new', 'second'])->default('new');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};