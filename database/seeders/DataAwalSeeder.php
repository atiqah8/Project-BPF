<?php

namespace Database\Seeders;

use App\Models\KaryawanInterna;
use App\Models\KategoriProduk;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DataAwalSeeder extends Seeder
{
    public function run($this->call(DataAwalSeeder::class);): void
    {
        $admin = KaryawanInterna::create([
            'nama_lengkap' => 'Admin Dapuramy', 'username' => 'admin',
            'email' => 'admin@dapuramy.test', 'password_hash' => 'password', 'role' => 'admin',
        ]);
        KaryawanInterna::create([
            'nama_lengkap' => 'Kasir 1', 'username' => 'kasir',
            'email' => 'kasir@dapuramy.test', 'password_hash' => 'password', 'role' => 'kasir_toko',
        ]);
        KaryawanInterna::create([
            'nama_lengkap' => 'Dapur 1', 'username' => 'dapur',
            'email' => 'dapur@dapuramy.test', 'password_hash' => 'password', 'role' => 'staf_dapur',
        ]);

        $cupcake = KategoriProduk::create(['nama_kategori' => 'Cupcake']);
        $ultah   = KategoriProduk::create(['nama_kategori' => 'Kue Ulang Tahun']);
        $kering  = KategoriProduk::create(['nama_kategori' => 'Kue Kering']);

        $produk = [
            ['Dozen Cupcakes', $cupcake, 85000, 20, 'ready_stock', 0, 'Vanilla lembut dengan buttercream'],
            ['Cookies and Cream Cupcake', $cupcake, 90000, 15, 'ready_stock', 0, 'Oreo crumble di atas cream cheese'],
            ['Choco Birthday Cake', $ultah, 250000, 0, 'made_to_order', 180, 'Coklat belgia, bisa tulis ucapan'],
            ['Red Velvet Cake', $ultah, 275000, 0, 'made_to_order', 240, 'Red velvet dengan cream cheese frosting'],
            ['Nastar Premium', $kering, 120000, 30, 'ready_stock', 0, 'Nastar selai nanas, toples 500 gr'],
            ['Kastengel Keju', $kering, 130000, 25, 'ready_stock', 0, 'Kastengel keju edam, toples 500 gr'],
        ];

        foreach ($produk as [$nama, $kat, $harga, $stok, $tipe, $menit, $rasa]) {
            Produk::create([
                'id_kategori' => $kat->id_kategori,
                'diinput_oleh' => $admin->id_karyawan,
                'nama_produk' => $nama,
                'deskripsi_rasa' => $rasa,
                'harga' => $harga,
                'stok_tersedia' => $stok,
                'daya_tahan_hari' => $tipe === 'ready_stock' ? 7 : 3,
                'tipe_produksi' => $tipe,
                'estimasi_siap_menit' => $menit,
            ]);
        }
    }
}