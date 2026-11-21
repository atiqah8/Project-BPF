<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    private function rules(): array
    {
        return [
            'id_kategori'         => 'required|exists:kategori_produk,id_kategori',
            'nama_produk'         => 'required|string|max:255',
            'deskripsi_rasa'      => 'nullable|string',
            'harga'               => 'required|numeric|min:0',
            'stok_tersedia'       => 'required|integer|min:0',
            'daya_tahan_hari'     => 'required|integer|min:0',
            'tipe_produksi'       => 'required|in:ready_stock,made_to_order',
            'estimasi_siap_menit' => 'required|integer|min:0',
            'foto'                => 'nullable|image|max:2048',
        ];
    }

    public function index()
    {
        $produk = Produk::with('kategori')->latest()->paginate(15);
        return view('admin.produk.index', compact('produk'));
    }

    public function create()
    {
        return view('admin.produk.form', [
            'produk'   => null,
            'kategori' => KategoriProduk::all(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        unset($data['foto']);

        if ($request->hasFile('foto')) {
            $data['foto_url'] = $request->file('foto')->store('produk', 'public');
        }

        $data['diinput_oleh']  = auth('karyawan')->id();
        $data['status_tampil'] = $request->boolean('status_tampil');

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('sukses', 'Produk ditambahkan');
    }

    public function edit(Produk $produk)
    {
        return view('admin.produk.form', [
            'produk'   => $produk,
            'kategori' => KategoriProduk::all(),
        ]);
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate($this->rules());
        unset($data['foto']);

        if ($request->hasFile('foto')) {
            if ($produk->foto_url) {
                Storage::disk('public')->delete($produk->foto_url);
            }
            $data['foto_url'] = $request->file('foto')->store('produk', 'public');
        }

        $data['status_tampil'] = $request->boolean('status_tampil');

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('sukses', 'Produk diperbarui');
    }

    public function destroy(Produk $produk)
    {
        // Produk yang pernah dipesan tidak boleh dihapus (supaya riwayat pesanan utuh),
        // cukup disembunyikan dari toko.
        if (DetailPesanan::where('id_produk', $produk->id_produk)->exists()) {
            $produk->update(['status_tampil' => false]);
            return back()->with('sukses', 'Produk pernah dipesan, jadi hanya disembunyikan dari toko');
        }

        if ($produk->foto_url) {
            Storage::disk('public')->delete($produk->foto_url);
        }
        $produk->delete();

        return back()->with('sukses', 'Produk dihapus');
    }
}