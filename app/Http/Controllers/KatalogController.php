<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request)
    {
        $produk = Produk::with('kategori')
            ->where('status_tampil', true)
            ->when($request->kategori, fn ($q, $k) => $q->where('id_kategori', $k))
            ->when($request->cari, fn ($q, $c) => $q->where('nama_produk', 'like', "%{$c}%"))
            ->paginate(12)
            ->withQueryString();

        $kategori = KategoriProduk::all();

        return view('katalog.index', compact('produk', 'kategori'));
    }

    public function show(Produk $produk)
    {
        abort_unless($produk->status_tampil, 404);
        $produk->load('kategori');

        return view('katalog.show', compact('produk'));
    }
}