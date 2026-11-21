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
    Schema::create('pembayaran', function (Blueprint $t) {
        $t->id('id_pembayaran');
        $t->foreignId('id_pesanan')->constrained('pesanan', 'id_pesanan')->cascadeOnDelete();
        $t->foreignId('diverifikasi_oleh')->nullable()->constrained('karyawan', 'id_karyawan');
        $t->enum('metode_pembayaran', ['QRIS', 'transfer_bank', 'tunai']);
        $t->decimal('jumlah_bayar', 12, 2);
        $t->string('bukti_transfer_url')->nullable();
        $t->enum('status_pembayaran', ['pending', 'valid', 'ditolak'])->default('pending');
        $t->timestamp('waktu_bayar')->nullable();
        $t->timestamps();
    });
    }
   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
