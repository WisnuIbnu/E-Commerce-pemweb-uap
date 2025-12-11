<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // <— tambahin ini

return new class extends Migration
{
    public function up(): void
    {
        // Ubah enum role jadi ada 'seller' juga
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM('admin', 'seller', 'member') 
            DEFAULT 'member'
        ");
    }

    public function down(): void
    {
        // Balikin lagi ke awal (kalau di-rollback)
        DB::statement("
            ALTER TABLE users 
            MODIFY role ENUM('admin', 'member') 
            DEFAULT 'member'
        ");
    }
};
