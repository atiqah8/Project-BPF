<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail';
    public $timestamps = false;
    protected $guarded = [];

    public function produk() { return $this->belongsTo(Produk::class, 'id_produk'); }
}