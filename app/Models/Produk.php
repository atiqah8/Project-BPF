<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $guarded = [];

    public function kategori()  { return $this->belongsTo(KategoriProduk::class, 'id_kategori'); }
    public function penginput() { return $this->belongsTo(KaryawanInterna::class, 'diinput_oleh'); }

    public function getRouteKeyName()
    {
        return 'id_produk';
    }
}