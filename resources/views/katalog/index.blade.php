@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<style>
    .chip-kategori {
        display: inline-block; padding: 8px 18px; margin: 0 6px 10px 0;
        border: 1px solid #d9d9d9; border-radius: 30px; color: #333;
        font-weight: 600; font-size: 14px; background: #fff; transition: all .15s;
    }
    .chip-kategori:hover { border-color: #f08632; color: #f08632; text-decoration: none; }
    .chip-kategori.aktif { background: #f08632; border-color: #f08632; color: #fff; }
    .chip-kategori small { opacity: .7; margin-left: 4px; }
    .kotak-cari { display: flex; max-width: 460px; margin-bottom: 20px; }
    .kotak-cari input { flex: 1; border: 1px solid #d9d9d9; padding: 10px 16px; border-radius: 4px 0 0 4px; }
    .kotak-cari button { border: 0; background: #111; color: #fff; padding: 0 22px; border-radius: 0 4px 4px 0; }
</style>

<section class="shop spad">
    <div class="container">

        {{-- Kotak pencarian (kategori yang sedang dipilih ikut terbawa) --}}
        <form method="GET" action="{{ route('katalog.index') }}" class="kotak-cari">
            @if (request('kategori'))
                <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            @endif
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari kue...">
            <button type="submit">Cari</button>
        </form>

        {{-- Tombol kategori: langsung memfilter saat diklik --}}
        <div class="mb-4">
            <a href="{{ route('katalog.index', array_filter(['cari' => request('cari')])) }}"
               class="chip-kategori {{ request('kategori') ? '' : 'aktif' }}">Semua</a>

            @foreach ($kategori as $k)
                <a href="{{ route('katalog.index', array_filter(['kategori' => $k->id_kategori, 'cari' => request('cari')])) }}"
                   class="chip-kategori {{ request('kategori') == $k->id_kategori ? 'aktif' : '' }}">
                    {{ $k->nama_kategori }}<small>({{ $k->produk_count }})</small>
                </a>
            @endforeach
        </div>

        {{-- Keterangan hasil --}}
        @if (request()->filled('kategori') || request()->filled('cari'))
            <p class="text-muted mb-4">
                Menampilkan {{ $produk->total() }} produk
                @if (request()->filled('cari')) untuk "<strong>{{ request('cari') }}</strong>" @endif
                @if (request()->filled('kategori'))
                    di kategori <strong>{{ $kategori->firstWhere('id_kategori', request('kategori'))?->nama_kategori }}</strong>
                @endif
                &middot; <a href="{{ route('katalog.index') }}">Reset</a>
            </p>
        @endif

        <div class="row">
            @forelse ($produk as $p)
                @include('katalog._kartu')
            @empty
                <div class="col-12 text-center py-5">
                    <p>Produk tidak ditemukan.</p>
                    <a href="{{ route('katalog.index') }}" class="btn btn-dark">Lihat semua produk</a>
                </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">{{ $produk->links() }}</div>
    </div>
</section>
@endsection