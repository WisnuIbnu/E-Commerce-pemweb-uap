<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            // Menambahkan kolom bank agar user bisa simpan rekeningnya
            $table->string('bank_name')->nullable()->after('postal_code');
            $table->string('bank_account_name')->nullable()->after('bank_name');
            $table->string('bank_account_number')->nullable()->after('bank_account_name');
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $table) {
            $table->dropColumn(['bank_name', 'bank_account_name', 'bank_account_number']);
        });
    }
};