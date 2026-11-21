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
    Schema::create('produk', function (Blueprint $t) {
        $t->id('id_produk');
        $t->foreignId('id_kategori')->constrained('kategori_produk', 'id_kategori');
        $t->foreignId('diinput_oleh')->constrained('karyawan', 'id_karyawan');
        $t->string('nama_produk');
        $t->text('deskripsi_rasa')->nullable();
        $t->decimal('harga', 12, 2);
        $t->integer('stok_tersedia')->default(0);
        $t->integer('daya_tahan_hari')->default(1);
        $t->enum('tipe_produksi', ['ready_stock', 'made_to_order']);
        $t->integer('estimasi_siap_menit')->default(0);
        $t->string('foto_url')->nullable();
        $t->boolean('status_tampil')->default(true);
        $t->timestamps();
    });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
