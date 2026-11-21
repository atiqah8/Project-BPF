<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void{
    Schema::create('pelanggan', function (Blueprint $t) {
        $t->id('id_pelanggan');
        $t->string('nama_pelanggan');
        $t->string('email')->unique();
        $t->string('no_whatsapp')->unique();
        $t->string('password_hash');
        $t->text('alamat_default')->nullable();
        $t->timestamps();
    });
    }
    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
