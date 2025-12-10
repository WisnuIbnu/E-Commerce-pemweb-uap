<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_balance_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_balance_id')
                ->constrained('store_balances')
                ->cascadeOnDelete();

            $table->enum('type', ['income', 'withdraw']);
            $table->char('reference_id', 36);
            $table->string('reference_type');
            $table->decimal('amount', 26, 2);
            $table->string('remarks');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('store_balance_histories');
    }
};
