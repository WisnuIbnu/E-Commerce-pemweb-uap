<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('name')->unique();
            $table->string('logo')->nullable();            // ADD
            $table->text('about')->nullable();             // ADD (replace description)
            $table->string('phone');

            $table->string('address_id')->nullable();      // ADD
            $table->string('city')->nullable();            // ADD
            $table->string('address');
            $table->string('postal_code')->nullable();     // ADD

            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
