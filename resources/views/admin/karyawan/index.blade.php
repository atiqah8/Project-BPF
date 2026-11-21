@extends('layouts.admin')
@section('title', 'Karyawan')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Karyawan</h4>
    <a href="{{ route('admin.karyawan.create') }}" class="btn btn-dark">+ Tambah Karyawan</a>
</div>

<table class="table table-bordered bg-white">
    <thead>
        <tr><th>Nama</th><th>Username</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr>
    </thead>
    @foreach ($karyawan as $k)
        <tr>
            <td>{{ $k->nama_lengkap }}</td>
            <td>{{ $k->username }}</td>
            <td>{{ $k->email }}</td>
            <td>{{ str_replace('_', ' ', $k->role) }}</td>
            <td>
                @if ($k->status_aktif)
                    <span class="badge badge-success">Aktif</span>
                @else
                    <span class="badge badge-secondary">Nonaktif</span>
                @endif
            </td>
            <td class="text-nowrap">
                <a href="{{ route('admin.karyawan.edit', $k) }}" class="btn btn-sm btn-outline-dark">Edit</a>
                @if ($k->status_aktif && $k->id_karyawan !== auth('karyawan')->id())
                    <form action="{{ route('admin.karyawan.destroy', $k) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Nonaktifkan karyawan ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Nonaktifkan</button>
                    </form>
                @endif
            </td>
        </tr>
    @endforeach
</table>
@endsection