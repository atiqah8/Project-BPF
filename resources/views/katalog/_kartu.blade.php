<div class="col-lg-3 col-md-6 col-sm-6">
    <div class="product__item">
        <div class="product__item__pic set-bg"
             data-setbg="{{ $p->foto_url ? asset('storage/' . $p->foto_url) : asset('img/shop/product-1.jpg') }}">
            <div class="product__label">
                <span>{{ $p->kategori->nama_kategori }}</span>
            </div>
        </div>
        <div class="product__item__text">
            <h6><a href="{{ route('katalog.show', $p) }}">{{ $p->nama_produk }}</a></h6>
            <div class="product__item__price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
            <div class="cart_add">
                <a href="{{ route('katalog.show', $p) }}">Lihat detail</a>
            </div>
        </div>
    </div>
</div>