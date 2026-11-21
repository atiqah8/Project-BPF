@extends('layouts.admin')
@section('title', 'Form Kategori')

@section('content')
<h4>{{ $kategori ? 'Edit' : 'Tambah' }} Kategori</h4>

<form method="POST"
      action="{{ $kategori ? route('admin.kategori.update', $kategori) : route('admin.kategori.store') }}">
    @csrf
    @if ($kategori) @method('PUT') @endif

    <div class="form-group">
        <label>Nama kategori</label>
        <input name="nama_kategori" class="form-control"
               value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}" required>
    </div>
    <div class="form-group">
        <label>Deskripsi</label>
        <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
    </div>

    <button class="btn btn-dark">Simpan</button>
    <a href="{{ route('admin.kategori.index') }}" class="btn btn-link">Batal</a>
</form>
@endsection