<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void // <--- LETAKKAN KODE UP DI SINI
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('saldo')->default(0)->after('email'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void // <--- LETAKKAN KODE DOWN DI SINI
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('saldo');
        });
    }
};