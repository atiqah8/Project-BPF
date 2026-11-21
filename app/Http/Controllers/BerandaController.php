<?php

namespace App\Http\Controllers;

use App\Models\Produk;

class BerandaController extends Controller
{
    public function index()
    {
        $produk = Produk::with('kategori')
            ->where('status_tampil', true)
            ->latest()->take(8)->get();

        return view('beranda', compact('produk'));
    }
}