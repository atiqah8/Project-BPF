@extends('layouts.admin')
@section('title', 'Form Karyawan')

@section('content')
<h4>{{ $karyawan ? 'Edit' : 'Tambah' }} Karyawan</h4>

<form method="POST"
      action="{{ $karyawan ? route('admin.karyawan.update', $karyawan) : route('admin.karyawan.store') }}">
    @csrf
    @if ($karyawan) @method('PUT') @endif

    <div class="form-group">
        <label>Nama lengkap</label>
        <input name="nama_lengkap" class="form-control"
               value="{{ old('nama_lengkap', $karyawan->nama_lengkap ?? '') }}" required>
    </div>

    <div class="form-row">
        <div class="form-group col-md-6">
            <label>Username (untuk login)</label>
            <input name="username" class="form-control"
                   value="{{ old('username', $karyawan->username ?? '') }}" required>
        </div>
        <div class="form-group col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $karyawan->email ?? '') }}" required>
        </div>
    </div>

    <div class="form-group">
        <label>Password {{ $karyawan ? '(kosongkan jika tidak diganti)' : '' }}</label>
        <input type="password" name="password" class="form-control"
               {{ $karyawan ? '' : 'required' }} placeholder="Minimal 6 karakter">
    </div>

    <div class="form-group">
        <label>Role</label>
        <select name="role" class="form-control">
            @foreach (['admin' => 'Admin', 'kasir_toko' => 'Kasir toko', 'staf_dapur' => 'Staf dapur'] as $nilai => $label)
                <option value="{{ $nilai }}"
                    @selected(old('role', $karyawan->role ?? '') === $nilai)>{{ $label }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-check mb-3">
        <input type="checkbox" name="status_aktif" value="1" id="aktif" class="form-check-input"
               @checked(old('status_aktif', $karyawan->status_aktif ?? true))>
        <label for="aktif" class="form-check-label">Akun aktif</label>
    </div>

    <button class="btn btn-dark">Simpan</button>
    <a href="{{ route('admin.karyawan.index') }}" class="btn btn-link">Batal</a>
</form>
@endsection