<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk.kategori')
            ->where('id_pelanggan', auth('pelanggan')->id())
            ->latest()
            ->get();

        $total = $items->sum(fn ($i) => $i->produk->harga * $i->jumlah);

        return view('keranjang.index', compact('items', 'total'));
    }

    public function store(Request $request, Produk $produk)
    {
        abort_unless($produk->status_tampil, 404);

        $data = $request->validate([
            'jumlah'       => 'nullable|integer|min:1|max:99',
            'catatan_item' => 'nullable|string|max:255',
        ]);

        $tambah = $data['jumlah'] ?? 1;

        $item = Keranjang::firstOrNew([
            'id_pelanggan' => auth('pelanggan')->id(),
            'id_produk'    => $produk->id_produk,
        ]);

        $jumlahBaru = ($item->jumlah ?? 0) + $tambah;

        // Produk ready stock tidak boleh melebihi stok
        if ($produk->tipe_produksi === 'ready_stock' && $jumlahBaru > $produk->stok_tersedia) {
            return back()->withErrors([
                'stok' => "Stok {$produk->nama_produk} tersisa {$produk->stok_tersedia}.",
            ]);
        }

        $item->jumlah = $jumlahBaru;
        if (!empty($data['catatan_item'])) {
            $item->catatan_item = $data['catatan_item'];
        }
        $item->save();

        return back()->with('sukses', "{$produk->nama_produk} ditambahkan ke keranjang.");
    }

    public function update(Request $request, Keranjang $keranjang)
    {
        abort_unless($keranjang->id_pelanggan === auth('pelanggan')->id(), 403);

        $data = $request->validate([
            'jumlah'       => 'required|integer|min:0|max:99',
            'catatan_item' => 'nullable|string|max:255',
        ]);

        // jumlah 0 berarti hapus dari keranjang
        if ((int) $data['jumlah'] === 0) {
            $keranjang->delete();
            return back()->with('sukses', 'Produk dihapus dari keranjang.');
        }

        $produk = $keranjang->produk;
        if ($produk->tipe_produksi === 'ready_stock' && $data['jumlah'] > $produk->stok_tersedia) {
            return back()->withErrors([
                'stok' => "Stok {$produk->nama_produk} tersisa {$produk->stok_tersedia}.",
            ]);
        }

        $keranjang->update([
            'jumlah'       => $data['jumlah'],
            'catatan_item' => $data['catatan_item'] ?? $keranjang->catatan_item,
        ]);

        return back()->with('sukses', 'Keranjang diperbarui.');
    }

    public function destroy(Keranjang $keranjang)
    {
        abort_unless($keranjang->id_pelanggan === auth('pelanggan')->id(), 403);

        $keranjang->delete();

        return back()->with('sukses', 'Produk dihapus dari keranjang.');
    }
}