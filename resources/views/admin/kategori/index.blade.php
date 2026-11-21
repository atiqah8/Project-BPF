@extends('layouts.admin')
@section('title', 'Kategori')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Kategori</h4>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-dark">+ Tambah Kategori</a>
</div>

<table class="table table-bordered bg-white">
    <thead>
        <tr><th>Nama</th><th>Deskripsi</th><th>Jumlah Produk</th><th></th></tr>
    </thead>
    @forelse ($kategori as $k)
        <tr>
            <td>{{ $k->nama_kategori }}</td>
            <td>{{ $k->deskripsi }}</td>
            <td>{{ $k->produk_count }}</td>
            <td class="text-nowrap">
                <a href="{{ route('admin.kategori.edit', $k) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                <form action="{{ route('admin.kategori.destroy', $k) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr><td colspan="4" class="text-center">Belum ada kategori</td></tr>
    @endforelse
</table>
@endsection