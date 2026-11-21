@extends('layouts.app')
@section('title', 'Produk')

@section('content')
<section class="shop spad">
    <div class="container">
        <form method="GET" class="form-inline mb-4">
            <select name="kategori" class="form-control mr-2">
                <option value="">Semua kategori</option>
                @foreach ($kategori as $k)
                    <option value="{{ $k->id_kategori }}" @selected(request('kategori') == $k->id_kategori)>
                        {{ $k->nama_kategori }}
                    </option>
                @endforeach
            </select>
            <input type="text" name="cari" value="{{ request('cari') }}" class="form-control mr-2" placeholder="Cari kue...">
            <button class="btn btn-dark">Cari</button>
        </form>

        <div class="row">
            @forelse ($produk as $p)
                @include('katalog._kartu')
            @empty
                <p class="text-center w-100">Produk tidak ditemukan.</p>
            @endforelse
        </div>

        <div class="d-flex justify-content-center">{{ $produk->links() }}</div>
    </div>
</section>
@endsection