<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade'); // Relasi dengan Store
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relasi dengan User
            $table->decimal('total_price', 8, 2); // Total harga pesanan
            $table->string('status')->default('pending'); // status pesanan (pending, completed, canceled, dll)
            $table->string('shipping_address'); // Alamat pengiriman
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid'); // Status pembayaran
            $table->enum('shipping_status', ['unshipped', 'shipped', 'delivered'])->default('unshipped'); // Status pengiriman
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
}
