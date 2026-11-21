@extends('layouts.app')
@section('title', 'Keranjang')

@section('content')
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="breadcrumb__text"><h2>Keranjang</h2></div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="breadcrumb__links">
                    <a href="{{ route('beranda') }}">Home</a>
                    <span>Keranjang</span>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="shopping-cart spad">
    <div class="container">
        @if ($items->isEmpty())
            <div class="text-center py-5">
                <p class="mb-3">Keranjangmu masih kosong.</p>
                <a href="{{ route('katalog.index') }}" class="btn btn-dark">Mulai belanja</a>
            </div>
        @else
        <div class="row">
            <div class="col-lg-8">
                <div class="shopping__cart__table">
                    <table>
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($items as $item)
                            @php
                                $p = $item->produk;
                                $kurang = $p->tipe_produksi === 'ready_stock' && $item->jumlah > $p->stok_tersedia;
                            @endphp
                            <tr>
                                <td class="product__cart__item">
                                    <div class="product__cart__item__pic">
                                        <img src="{{ $p->foto_url ? asset('storage/'.$p->foto_url) : asset('img/shop/product-1.jpg') }}"
                                             alt="{{ $p->nama_produk }}" style="width:90px; height:90px; object-fit:cover">
                                    </div>
                                    <div class="product__cart__item__text">
                                        <h6>{{ $p->nama_produk }}</h6>
                                        <h5>Rp {{ number_format($p->harga, 0, ',', '.') }}</h5>
                                        @if ($item->catatan_item)
                                            <small class="text-muted">Catatan: {{ $item->catatan_item }}</small>
                                        @endif
                                        @if ($kurang)
                                            <br><small class="text-danger">Stok tersisa {{ $p->stok_tersedia }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td class="quantity__item">
                                    <form action="{{ route('keranjang.update', $item) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input type="text" name="jumlah" value="{{ $item->jumlah }}">
                                            </div>
                                        </div>
                                    </form>
                                </td>
                                <td class="cart__price">Rp {{ number_format($p->harga * $item->jumlah, 0, ',', '.') }}</td>
                                <td class="cart__close">
                                    <form action="{{ route('keranjang.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link p-0" style="color:inherit" aria-label="Hapus">
                                            <span class="icon_close"></span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6">
                        <div class="continue__btn">
                            <a href="{{ route('katalog.index') }}">Lanjut belanja</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="cart__total">
                    <h6>Total belanja</h6>
                    <ul>
                        <li>Jumlah item <span>{{ $items->sum('jumlah') }}</span></li>
                        <li>Total <span>Rp {{ number_format($total, 0, ',', '.') }}</span></li>
                    </ul>
                    <a href="{{ Route::has('checkout') ? route('checkout') : '#' }}" class="primary-btn">Lanjut ke checkout</a>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
    // Setelah tombol + atau - diklik, simpan otomatis jumlah barunya
    // (script template main.js sudah mengubah angkanya lebih dulu)
    $('.pro-qty').on('click', '.qtybtn', function () {
        $(this).closest('form').submit();
    });
    // Kalau jumlah diketik manual, simpan saat kolom ditinggalkan atau Enter ditekan
    $('.pro-qty input').on('change', function () {
        $(this).closest('form').submit();
    });
</script>
@endpush