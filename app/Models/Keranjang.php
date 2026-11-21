<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    protected $table = 'keranjang';
    protected $primaryKey = 'id_keranjang';
    protected $guarded = [];

    public function produk() { return $this->belongsTo(Produk::class, 'id_produk'); }

    public function getRouteKeyName()
    {
        return 'id_keranjang';
    }
}