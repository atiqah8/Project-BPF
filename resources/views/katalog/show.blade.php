@extends('layouts.app')
@section('title', $produk->nama_produk)

@section('content')
@php
    $habis = $produk->tipe_produksi === 'ready_stock' && $produk->stok_tersedia < 1;
@endphp

<section class="shop spad">
    <div class="container">
        <a href="{{ route('katalog.index') }}" class="d-inline-block mb-4">&larr; Kembali ke produk</a>

        <div class="row">
            <div class="col-md-5 mb-4">
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

                @if ($habis)
                    <p class="text-danger font-weight-bold">Stok habis</p>

                @elseif (auth('pelanggan')->check())
                    <form action="{{ route('keranjang.store', $produk) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="form-row">
                            <div class="form-group col-4 col-md-3">
                                <label>Jumlah</label>
                                <input type="number" name="jumlah" value="1" min="1" max="99" class="form-control">
                            </div>
                            <div class="form-group col-12">
                                <label>Catatan (opsional)</label>
                                <input type="text" name="catatan_item" maxlength="255" class="form-control"
                                       placeholder="Contoh: tulis 'Happy Birthday Rani'">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-dark">Tambah ke keranjang</button>
                        <a href="{{ route('keranjang.index') }}" class="btn btn-link">Lihat keranjang</a>
                    </form>

                @else
                    <a href="{{ route('login') }}" class="btn btn-dark mt-3">Masuk untuk memesan</a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection