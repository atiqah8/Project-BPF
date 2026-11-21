@extends('layouts.admin')
@section('title', 'Form Produk')

@section('content')
<h4>{{ $produk ? 'Edit' : 'Tambah' }} Produk</h4>

<form method="POST" enctype="multipart/form-data"
      action="{{ $produk ? route('admin.produk.update', $produk) : route('admin.produk.store') }}">
    @csrf
    @if ($produk) @method('PUT') @endif

    <div class="form-group">
        <label>Kategori</label>
        <select name="id_kategori" class="form-control" required>
            @foreach ($kategori as $k)
                <option value="{{ $k->id_kategori }}"
                    @selected(old('id_kategori', $produk->id_kategori ?? '') == $k->id_kategori)>
                    {{ $k->nama_kategori }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label>Nama produk</label>
        <input name="nama_produk" class="form-control"
               value="{{ old('nama_produk', $produk->nama_produk ?? '') }}" required>
    </div>

    <div class="form-group">
        <label>Deskripsi rasa</label>
        <textarea name="deskripsi_rasa" class="form-control">{{ old('deskripsi_rasa', $produk->deskripsi_rasa ?? '') }}</textarea>
    </div>

    <div class="form-row">
        <div class="form-group col-md-3">
            <label>Harga (Rp)</label>
            <input type="number" name="harga" class="form-control"
                   value="{{ old('harga', isset($produk) ? (int) $produk->harga : '') }}" required>
        </div>
        <div class="form-group col-md-3">
            <label>Stok</label>
            <input type="number" name="stok_tersedia" class="form-control"
                   value="{{ old('stok_tersedia', $produk->stok_tersedia ?? 0) }}" required>
        </div>
        <div class="form-group col-md-3">
            <label>Daya tahan (hari)</label>
            <input type="number" name="daya_tahan_hari" class="form-control"
                   value="{{ old('daya_tahan_hari', $produk->daya_tahan_hari ?? 1) }}" required>
        </div>
        <div class="form-group col-md-3">
            <label>Estimasi siap (menit)</label>
            <input type="number" name="estimasi_siap_menit" class="form-control"
                   value="{{ old('estimasi_siap_menit', $produk->estimasi_siap_menit ?? 0) }}" required>
        </div>
    </div>

    <div class="form-group">
        <label>Tipe produksi</label>
        <select name="tipe_produksi" class="form-control">
            <option value="ready_stock" @selected(old('tipe_produksi', $produk->tipe_produksi ?? '') === 'ready_stock')>
                ready_stock (stok langsung ada)
            </option>
            <option value="made_to_order" @selected(old('tipe_produksi', $produk->tipe_produksi ?? '') === 'made_to_order')>
                made_to_order (dibuat setelah dipesan)
            </option>
        </select>
    </div>

    <div class="form-group">
        <label>Foto</label>
        @if ($produk && $produk->foto_url)
            <div class="mb-2"><img src="{{ asset('storage/' . $produk->foto_url) }}" width="120" alt=""></div>
        @endif
        <input type="file" name="foto" class="form-control-file" accept="image/*">
        <small class="text-muted">Maksimal 2 MB. Kosongkan kalau tidak ingin mengganti foto.</small>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="status_tampil" value="1" id="tampil" class="form-check-input"
               @checked(old('status_tampil', $produk->status_tampil ?? true))>
        <label for="tampil" class="form-check-label">Tampilkan di toko</label>
    </div>

    <button class="btn btn-dark">Simpan</button>
    <a href="{{ route('admin.produk.index') }}" class="btn btn-link">Batal</a>
</form>
@endsection