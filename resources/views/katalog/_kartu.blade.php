@php
    $habis = $p->tipe_produksi === 'ready_stock' && $p->stok_tersedia < 1;
@endphp

<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="product__item">

        {{-- Gambar: bisa diklik ke halaman detail --}}
        <a href="{{ route('katalog.show', $p) }}"
           class="product__item__pic set-bg d-block"
           data-setbg="{{ $p->foto_url ? asset('storage/' . $p->foto_url) : asset('img/shop/product-1.jpg') }}">
            <div class="product__label">
                <span>{{ $p->kategori->nama_kategori }}</span>
            </div>
        </a>

        <div class="product__item__text">
            {{-- Nama: bisa diklik ke halaman detail --}}
            <h6><a href="{{ route('katalog.show', $p) }}">{{ $p->nama_produk }}</a></h6>
            <div class="product__item__price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>

            <div class="cart_add">
                <a href="{{ route('katalog.show', $p) }}">
                    {{ $habis ? 'Stok habis' : 'Lihat detail' }}
                </a>
            </div>
        </div>
    </div>
</div>