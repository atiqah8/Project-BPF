<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $guarded = [];
    protected $casts = [
        'waktu_ambil_kirim' => 'datetime',
        'tanggal_pesanan'   => 'datetime',
    ];

    public function pelanggan()  { return $this->belongsTo(Pelanggan::class, 'id_pelanggan'); }
    public function kasir()      { return $this->belongsTo(Karyawan::class, 'diproses_kasir_id'); }
    public function dapur()      { return $this->belongsTo(Karyawan::class, 'disiapkan_dapur_id'); }
    public function detail()     { return $this->hasMany(DetailPesanan::class, 'id_pesanan'); }
    public function pembayaran() { return $this->hasOne(Pembayaran::class, 'id_pesanan'); }

    public function getRouteKeyName()
    {
        return 'id_pesanan';
    }
}