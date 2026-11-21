@extends('layouts.app')
@section('title', $produk->nama_produk)

@section('content')
<section class="shop spad">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img class="img-fluid"
                     src="{{ $produk->foto_url ? asset('storage/' . $produk->foto_url) : asset('img/shop/product-1.jpg') }}"
                     alt="{{ $produk->nama_produk }}">
            </div>
            <div class="col-md-7">
                <span class="badge badge-secondary">{{ $produk->kategori->nama_kategori }}</span>
                <h3 class="mt-2">{{ $produk->nama_produk }}</h3>
                <h4>Rp {{ number_format($produk->harga, 0, ',', '.') }}</h4>
                <p>{{ $produk->deskripsi_rasa }}</p>
                <ul>
                    <li>Daya tahan: {{ $produk->daya_tahan_hari }} hari</li>
                    @if ($produk->tipe_produksi === 'ready_stock')
                        <li>Stok: {{ $produk->stok_tersedia }}</li>
                    @else
                        <li>Dibuat setelah dipesan (sekitar {{ intdiv($produk->estimasi_siap_menit, 60) }} jam)</li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection