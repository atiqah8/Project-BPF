@extends('layouts.admin')
@section('title', 'Produk')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Produk</h4>
    <a href="{{ route('admin.produk.create') }}" class="btn btn-dark">+ Tambah Produk</a>
</div>

<table class="table table-bordered bg-white">
    <thead>
        <tr>
            <th>Foto</th><th>Nama</th><th>Kategori</th><th>Harga</th>
            <th>Stok</th><th>Tipe</th><th>Tampil</th><th></th>
        </tr>
    </thead>
    @forelse ($produk as $p)
        <tr>
            <td>
                @if ($p->foto_url)
                    <img src="{{ asset('storage/' . $p->foto_url) }}" width="60" alt="">
                @endif
            </td>
            <td>{{ $p->nama_produk }}</td>
            <td>{{ $p->kategori->nama_kategori }}</td>
            <td>Rp {{ number_format($p->harga, 0, ',', '.') }}</td>
            <td>{{ $p->tipe_produksi === 'ready_stock' ? $p->stok_tersedia : '-' }}</td>
            <td>{{ $p->tipe_produksi }}</td>
            <td>{{ $p->status_tampil ? 'Ya' : 'Tidak' }}</td>
            <td class="text-nowrap">
                <a href="{{ route('admin.produk.edit', $p) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                <form action="{{ route('admin.produk.destroy', $p) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="8" class="text-center">Belum ada produk</td></tr>
    @endforelse
</table>

{{ $produk->links() }}
@endsection