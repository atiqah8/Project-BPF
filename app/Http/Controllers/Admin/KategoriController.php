<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    private function rules(): array
    {
        return [
            'nama_kategori' => 'required|string|max:255',
            'deskripsi'     => 'nullable|string',
        ];
    }

    public function index()
    {
        $kategori = KategoriProduk::withCount('produk')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('admin.kategori.form', ['kategori' => null]);
    }

    public function store(Request $request)
    {
        KategoriProduk::create($request->validate($this->rules()));
        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori ditambahkan');
    }

    public function edit(KategoriProduk $kategori)
    {
        return view('admin.kategori.form', compact('kategori'));
    }

    public function update(Request $request, KategoriProduk $kategori)
    {
        $kategori->update($request->validate($this->rules()));
        return redirect()->route('admin.kategori.index')->with('sukses', 'Kategori diperbarui');
    }

    public function destroy(KategoriProduk $kategori)
    {
        if ($kategori->produk()->exists()) {
            return back()->withErrors(['kategori' => 'Kategori masih dipakai produk, tidak bisa dihapus']);
        }

        $kategori->delete();
        return back()->with('sukses', 'Kategori dihapus');
    }
}