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
    Schema::create('pesanan', function (Blueprint $t) {
        $t->id('id_pesanan');
        $t->string('kode_invoice')->unique();
        $t->foreignId('id_pelanggan')->constrained('pelanggan', 'id_pelanggan');
        $t->foreignId('diproses_kasir_id')->nullable()->constrained('karyawan_interna', 'id_karyawan');
        $t->foreignId('disiapkan_dapur_id')->nullable()->constrained('karyawan_interna', 'id_karyawan');
        $t->timestamp('tanggal_pesanan')->useCurrent();
        $t->dateTime('waktu_ambil_kirim');
        $t->enum('metode_pengambilan', ['ambil_di_gerai', 'kurir_lokal', 'ekspedisi']);
        $t->text('alamat_pengiriman')->nullable();
        $t->decimal('total_harga', 12, 2)->default(0);
        $t->enum('status_pesanan', [
            'menunggu_pembayaran', 'menunggu_verifikasi', 'diproses',
            'siap', 'selesai', 'revisi', 'dibatalkan',
        ])->default('menunggu_pembayaran');
        $t->text('catatan_revisi')->nullable();
        $t->timestamps();
    });
    }
    public function down(): void { Schema::dropIfExists('pesanan'); }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
