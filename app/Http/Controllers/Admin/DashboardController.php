<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Pelanggan;
use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Models\Produk;

class DashboardController extends Controller
{
    public function index()
    {
        $role = auth('karyawan')->user()->role;

        $pendapatan = Pembayaran::where('status_pembayaran', 'valid')
            ->whereMonth('waktu_bayar', now()->month)
            ->whereYear('waktu_bayar', now()->year)
            ->sum('jumlah_bayar');

        // Semua kemungkinan kartu: [label, nilai, ikon, warna]
        $semua = [
            'pesananHariIni'     => ['Pesanan hari ini', Pesanan::whereDate('tanggal_pesanan', today())->count(), 'fa-shopping-bag', 'rose'],
            'menungguVerifikasi' => ['Perlu verifikasi', Pesanan::where('status_pesanan', 'menunggu_verifikasi')->count(), 'fa-credit-card', 'amber'],
            'antrianDapur'       => ['Antrian dapur', Pesanan::where('status_pesanan', 'diproses')->count(), 'fa-fire', 'blue'],
            'siap'               => ['Siap diambil/dikirim', Pesanan::where('status_pesanan', 'siap')->count(), 'fa-check-circle', 'green'],
            'pendapatan'         => ['Pendapatan bulan ini', 'Rp ' . number_format($pendapatan, 0, ',', '.'), 'fa-money', 'green'],
            'produk'             => ['Total produk', Produk::count(), 'fa-birthday-cake', 'brown'],
            'kategori'           => ['Kategori', KategoriProduk::count(), 'fa-tags', 'purple'],
            'pelanggan'          => ['Pelanggan', Pelanggan::count(), 'fa-users', 'blue'],
        ];

        $urutan = match ($role) {
            'admin'      => ['pesananHariIni', 'menungguVerifikasi', 'pendapatan', 'produk', 'kategori', 'pelanggan'],
            'kasir_toko' => ['pesananHariIni', 'menungguVerifikasi', 'siap', 'pendapatan'],
            default      => ['antrianDapur', 'siap', 'pesananHariIni'],
        };

        $kartu = collect($urutan)->map(fn ($k) => $semua[$k]);

        return view('admin.dashboard', [
            'kartu'          => $kartu,
            'pesananTerbaru' => Pesanan::with('pelanggan')->latest('tanggal_pesanan')->take(5)->get(),
            'stokMenipis'    => Produk::where('tipe_produksi', 'ready_stock')
                                    ->where('stok_tersedia', '<=', 5)
                                    ->orderBy('stok_tersedia')->take(5)->get(),
        ]);
    }
}