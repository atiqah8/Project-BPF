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
    Schema::create('detail_pesanan', function (Blueprint $t) {
        $t->id('id_detail');
        $t->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->cascadeOnDelete();
        $t->foreignId('id_produk')->constrained('produk', 'id_produk');
        $t->integer('jumlah');
        $t->decimal('harga_satuan_saat_beli', 12, 2);
        $t->decimal('subtotal', 12, 2);
        $t->string('catatan_item')->nullable();
    });
    }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
