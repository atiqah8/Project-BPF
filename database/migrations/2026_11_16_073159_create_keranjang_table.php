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
    Schema::create('keranjang', function (Blueprint $t) {
        $t->id('id_keranjang');
        $t->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan')->cascadeOnDelete();
        $t->foreignId('id_produk')->constrained('produk', 'id_produk')->cascadeOnDelete();
        $t->integer('jumlah')->default(1);
        $t->string('catatan_item')->nullable();
        $t->timestamps();
    });
    }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};
