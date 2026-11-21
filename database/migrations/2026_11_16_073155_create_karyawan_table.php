<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('karyawan', function (Blueprint $t) {
            $t->id('id_karyawan');
            $t->string('nama_lengkap');
            $t->string('username')->unique();
            $t->string('email')->unique();
            $t->string('password_hash');
            $t->enum('role', ['admin', 'kasir_toko', 'staf_dapur']);
            $t->boolean('status_aktif')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('karyawan');
    }
};