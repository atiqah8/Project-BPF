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
        ->when($request->filled('kategori'), fn ($q) => $q->where('id_kategori', $request->kategori))
        ->when($request->filled('cari'), function ($q) use ($request) {
            $kata = trim($request->cari);

            // dikelompokkan dalam satu kurung supaya tidak merusak filter kategori
            $q->where(function ($sub) use ($kata) {
                $sub->where('nama_produk', 'like', "%{$kata}%")
                    ->orWhere('deskripsi_rasa', 'like', "%{$kata}%")
                    ->orWhereHas('kategori', fn ($k) => $k->where('nama_kategori', 'like', "%{$kata}%"));
            });
        })
        ->latest()
        ->paginate(12)
        ->withQueryString();

    $kategori = KategoriProduk::withCount([
        'produk' => fn ($q) => $q->where('status_tampil', true),
    ])->get();

    return view('katalog.index', compact('produk', 'kategori'));
}

    public function show(Produk $produk)
    {
        abort_unless($produk->status_tampil, 404);
        $produk->load('kategori');

        return view('katalog.show', compact('produk'));
    }
}