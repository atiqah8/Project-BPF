@extends('layouts.admin')
@section('title', 'Dashboard')

@php
    $user = auth('karyawan')->user();
    $jam = now()->format('H');
    $sapaan = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));

    $labelStatus = [
        'menunggu_pembayaran' => ['Menunggu bayar', 'secondary'],
        'menunggu_verifikasi' => ['Perlu verifikasi', 'warning'],
        'diproses'            => ['Diproses', 'info'],
        'siap'                => ['Siap', 'primary'],
        'selesai'             => ['Selesai', 'success'],
        'revisi'              => ['Revisi', 'danger'],
        'dibatalkan'          => ['Dibatalkan', 'dark'],
    ];
@endphp

@section('content')

{{-- Banner sapaan --}}
<div class="kartu-putih mb-4" style="background: linear-gradient(120deg, #3b2a24 0%, #7a4b3a 100%); color: #fff;">
    <div class="badan d-flex justify-content-between align-items-center flex-wrap" style="padding: 26px 28px;">
        <div>
            <div style="opacity:.75">{{ $sapaan }},</div>
            <h3 class="mb-1" style="font-weight:700">{{ $user->nama_lengkap }} 👋</h3>
            <div style="opacity:.75">{{ now()->translatedFormat('l, d F Y') }}</div>
        </div>
        <i class="fa fa-birthday-cake d-none d-md-block" style="font-size:4.5rem; opacity:.18"></i>
    </div>
</div>

{{-- Kartu statistik --}}
<div class="row">
    @foreach ($kartu as [$label, $nilai, $ikon, $warna])
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="kartu-putih stat">
                <div class="ikon ikon-{{ $warna }}"><i class="fa {{ $ikon }}"></i></div>
                <div>
                    <div class="angka">{{ $nilai }}</div>
                    <div class="label">{{ $label }}</div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div class="row">
    {{-- Pesanan terbaru --}}
    <div class="col-lg-7 mb-4">
        <div class="kartu-putih h-100">
            <div class="kepala">Pesanan terbaru</div>
            <div class="badan">
                @if ($pesananTerbaru->isEmpty())
                    <div class="text-center text-muted py-4">
                        <i class="fa fa-shopping-bag" style="font-size:2rem; opacity:.3"></i>
                        <p class="mt-2 mb-0">Belum ada pesanan masuk</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr><th>Invoice</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr>
                            </thead>
                            @foreach ($pesananTerbaru as $p)
                                @php [$teks, $warna] = $labelStatus[$p->status_pesanan] ?? [$p->status_pesanan, 'secondary']; @endphp
                                <tr>
                                    <td>
                                        {{ $p->kode_invoice }}<br>
                                        <small class="text-muted">{{ $p->tanggal_pesanan->format('d M, H:i') }}</small>
                                    </td>
                                    <td>{{ $p->pelanggan->nama_pelanggan }}</td>
                                    <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                    <td><span class="badge badge-{{ $warna }}">{{ $teks }}</span></td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Kolom kanan --}}
    <div class="col-lg-5 mb-4">
        {{-- Stok menipis --}}
        <div class="kartu-putih mb-4">
            <div class="kepala">Stok menipis</div>
            <div class="badan">
                @forelse ($stokMenipis as $p)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <span>{{ $p->nama_produk }}</span>
                        <span class="badge badge-{{ $p->stok_tersedia == 0 ? 'danger' : 'warning' }}">
                            {{ $p->stok_tersedia == 0 ? 'Habis' : 'Sisa ' . $p->stok_tersedia }}
                        </span>
                    </div>
                @empty
                    <div class="text-center text-muted py-3">
                        <i class="fa fa-check-circle" style="font-size:1.8rem; color:#2f9e57; opacity:.7"></i>
                        <p class="mt-2 mb-0">Semua stok aman</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Aksi cepat (hanya admin) --}}
        @if ($user->role === 'admin')
            <div class="kartu-putih">
                <div class="kepala">Aksi cepat</div>
                <div class="badan">
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-coklat btn-block text-left mb-2">
                        <i class="fa fa-plus mr-2"></i>Tambah produk
                    </a>
                    <a href="{{ route('admin.kategori.create') }}" class="btn btn-outline-dark btn-block text-left mb-2">
                        <i class="fa fa-tags mr-2"></i>Tambah kategori
                    </a>
                    @if (Route::has('admin.karyawan.create'))
                        <a href="{{ route('admin.karyawan.create') }}" class="btn btn-outline-dark btn-block text-left">
                            <i class="fa fa-user-plus mr-2"></i>Tambah karyawan
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection