@extends('layouts.app')
@section('title', 'Dapuramy')

@section('content')
<section class="shop spad">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Dapuramy</h2>
            <p>Kue segar dan kue pesanan untuk setiap momen</p>
            <a href="{{ route('katalog.index') }}" class="btn btn-dark">Lihat semua produk</a>
        </div>
        <div class="row">
            @foreach ($produk as $p)
                @include('katalog._kartu')
            @endforeach
        </div>
    </div>
</section>
@endsection