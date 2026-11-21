<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class KaryawanInterna extends Authenticatable
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $guarded = [];
    protected $hidden = ['password_hash'];
    protected $casts = ['password_hash' => 'hashed', 'status_aktif' => 'boolean'];

    public function getAuthPasswordName()
    {
        return 'password_hash';
    }
}