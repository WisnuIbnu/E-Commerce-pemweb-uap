<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // ubah jadi string max 20, dengan default 'pending'
            $table->string('payment_status', 20)->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            // kalau mau, bisa dikembalikan ke ENUM / tipe awal
            // SESUAIKAN DENGAN TIPE AWAL KAMU
            // Contoh (kalau awalnya enum):
            // $table->enum('payment_status', ['pending', 'paid', 'cancelled'])->change();
        });
    }
};
