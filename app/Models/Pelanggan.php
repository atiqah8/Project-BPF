<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pelanggan extends Authenticatable
{
    protected $table = 'pelanggan';
    protected $primaryKey = 'id_pelanggan';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
    protected $casts = ['password_hash' => 'hashed'];

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }

    public function keranjang() { return $this->hasMany(Keranjang::class, 'id_pelanggan'); }
    public function pesanan()   { return $this->hasMany(Pesanan::class, 'id_pelanggan'); }
}