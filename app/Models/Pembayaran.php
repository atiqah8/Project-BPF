<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';
    protected $primaryKey = 'id_pembayaran';
    protected $guarded = [];

    public function pesanan()     { return $this->belongsTo(Pesanan::class, 'id_pesanan'); }
    public function verifikator() { return $this->belongsTo(KaryawanInterna::class, 'diverifikasi_oleh'); }

    public function getRouteKeyName()
    {
        return 'id_pembayaran';
    }
}