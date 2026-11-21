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
    Schema::create('kategori_produk', function (Blueprint $t) {
        $t->id('id_kategori');
        $t->string('nama_kategori');
        $t->text('deskripsi')->nullable();
    });
    }
    public function down(): void { Schema::dropIfExists('kategori_produk'); }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_produk');
    }
};
