<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Panel') - Dapuramy</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <style>
        :root {
            --coklat: #3b2a24;
            --coklat-muda: #54403a;
            --karamel: #e8a05d;
            --krem: #faf6f2;
            --teks: #3d3430;
        }
        body { background: var(--krem); color: var(--teks); font-family: 'Segoe UI', system-ui, sans-serif; }

        /* ===== Sidebar ===== */
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0; width: 250px;
            background: var(--coklat); color: #f3e9e2;
            display: flex; flex-direction: column; z-index: 1040;
            transition: transform .25s ease;
        }
        .sidebar .brand {
            padding: 22px 24px; font-size: 1.3rem; font-weight: 700; letter-spacing: .5px;
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .sidebar .brand i { color: var(--karamel); margin-right: 8px; }
        .sidebar .brand small { display: block; font-size: .72rem; font-weight: 400; opacity: .6; letter-spacing: 1px; text-transform: uppercase; }
        .sidebar nav { padding: 16px 12px; flex: 1; overflow-y: auto; }
        .sidebar .judul-menu { font-size: .68rem; text-transform: uppercase; letter-spacing: 1.2px; opacity: .45; padding: 8px 14px; }
        .sidebar a.item {
            display: flex; align-items: center; padding: 11px 14px; margin-bottom: 4px;
            color: #e6d9d0; border-radius: 10px; text-decoration: none; transition: background .15s;
        }
        .sidebar a.item i { width: 26px; font-size: 1.05rem; color: var(--karamel); }
        .sidebar a.item:hover { background: var(--coklat-muda); color: #fff; }
        .sidebar a.item.aktif { background: var(--karamel); color: var(--coklat); font-weight: 600; }
        .sidebar a.item.aktif i { color: var(--coklat); }
        .sidebar .bawah { padding: 14px 12px; border-top: 1px solid rgba(255,255,255,.08); }

        /* ===== Konten utama ===== */
        .main { margin-left: 250px; min-height: 100vh; }
        .topbar {
            background: #fff; padding: 14px 28px; display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 1px 6px rgba(60,40,30,.07); position: sticky; top: 0; z-index: 1030;
        }
        .topbar h5 { margin: 0; font-weight: 600; }
        .toggle-btn { display: none; background: none; border: 0; font-size: 1.4rem; color: var(--coklat); margin-right: 12px; }
        .profil { display: flex; align-items: center; }
        .avatar {
            width: 40px; height: 40px; border-radius: 50%; background: var(--karamel); color: var(--coklat);
            display: flex; align-items: center; justify-content: center; font-weight: 700; margin-right: 10px;
        }
        .profil .nama { line-height: 1.2; font-weight: 600; font-size: .92rem; }
        .profil .peran { font-size: .75rem; color: #8a7b73; }
        .konten { padding: 28px; }

        /* ===== Komponen umum ===== */
        .kartu-putih { background: #fff; border-radius: 16px; box-shadow: 0 2px 10px rgba(60,40,30,.06); border: 0; }
        .kartu-putih .kepala { padding: 18px 22px 0; font-weight: 600; display: flex; justify-content: space-between; align-items: center; }
        .kartu-putih .badan { padding: 18px 22px 22px; }
        .table { margin-bottom: 0; }
        .table thead th { border-top: 0; font-size: .78rem; text-transform: uppercase; letter-spacing: .5px; color: #8a7b73; }
        .btn-coklat { background: var(--coklat); color: #fff; border: 0; }
        .btn-coklat:hover { background: var(--coklat-muda); color: #fff; }

        /* ===== Kartu statistik ===== */
        .stat { display: flex; align-items: center; padding: 20px 22px; }
        .stat .ikon {
            width: 54px; height: 54px; border-radius: 14px; font-size: 1.5rem;
            display: flex; align-items: center; justify-content: center; margin-right: 16px; flex-shrink: 0;
        }
        .stat .angka { font-size: 1.55rem; font-weight: 700; line-height: 1.1; }
        .stat .label { font-size: .82rem; color: #8a7b73; }
        .ikon-rose   { background: #fde6ee; color: #d6336c; }
        .ikon-amber  { background: #fff0d9; color: #e08a1e; }
        .ikon-green  { background: #def5e5; color: #2f9e57; }
        .ikon-blue   { background: #e0edff; color: #3b82f6; }
        .ikon-purple { background: #ece4fb; color: #7c4dcc; }
        .ikon-brown  { background: #f1e4da; color: #8d5a3b; }

        .backdrop { display: none; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            body.sidebar-open .sidebar { transform: none; }
            body.sidebar-open .backdrop {
                display: block; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 1035;
            }
            .main { margin-left: 0; }
            .toggle-btn { display: inline-block; }
            .profil .teks-profil { display: none; }
            .konten { padding: 18px; }
        }
    </style>
</head>
<body>
@php
    $user = auth('karyawan')->user();
    $namaRole = ['admin' => 'Admin', 'kasir_toko' => 'Kasir Toko', 'staf_dapur' => 'Staf Dapur'][$user->role] ?? $user->role;

    // Menu tampil hanya kalau role cocok DAN halamannya sudah ada (route terdaftar)
    $menu = [
        ['admin.dashboard',         'admin.dashboard',   'Dashboard',  'fa-home',          ['admin', 'kasir_toko', 'staf_dapur']],
        ['admin.pembayaran.index',  'admin.pembayaran.*','Pembayaran', 'fa-credit-card',   ['admin', 'kasir_toko']],
        ['admin.pesanan.index',     'admin.pesanan.*',   'Pesanan',    'fa-shopping-bag',  ['admin', 'kasir_toko']],
        ['admin.dapur.index',       'admin.dapur.*',     'Dapur',      'fa-fire',          ['admin', 'staf_dapur']],
        ['admin.produk.index',      'admin.produk.*',    'Produk',     'fa-birthday-cake', ['admin']],
        ['admin.kategori.index',    'admin.kategori.*',  'Kategori',   'fa-tags',          ['admin']],
        ['admin.karyawan.index',    'admin.karyawan.*',  'Karyawan',   'fa-users',         ['admin']],
    ];
@endphp

<aside class="sidebar">
    <div class="brand">
        <i class="fa fa-birthday-cake"></i>Dapuramy
        <small>Panel Karyawan</small>
    </div>
    <nav>
        <div class="judul-menu">Menu</div>
        @foreach ($menu as [$rute, $pola, $label, $ikon, $boleh])
            @if (in_array($user->role, $boleh) && Route::has($rute))
                <a href="{{ route($rute) }}" class="item {{ request()->routeIs($pola) ? 'aktif' : '' }}">
                    <i class="fa {{ $ikon }}"></i>{{ $label }}
                </a>
            @endif
        @endforeach
    </nav>
    <div class="bawah">
        <a href="{{ route('beranda') }}" target="_blank" class="item">
            <i class="fa fa-external-link"></i>Lihat Toko
        </a>
        <form action="{{ route('karyawan.logout') }}" method="POST">
            @csrf
            <button type="submit" class="item btn btn-link w-100 text-left" style="border:0;background:none">
                <i class="fa fa-sign-out"></i>Logout
            </button>
        </form>
    </div>
</aside>
<div class="backdrop" onclick="document.body.classList.remove('sidebar-open')"></div>

<div class="main">
    <header class="topbar">
        <div class="d-flex align-items-center">
            <button class="toggle-btn" onclick="document.body.classList.toggle('sidebar-open')" aria-label="Menu">
                <i class="fa fa-bars"></i>
            </button>
            <h5>@yield('title', 'Panel')</h5>
        </div>
        <div class="profil">
            <div class="avatar">{{ strtoupper(substr($user->nama_lengkap, 0, 1)) }}</div>
            <div class="teks-profil">
                <div class="nama">{{ $user->nama_lengkap }}</div>
                <div class="peran">{{ $namaRole }}</div>
            </div>
        </div>
    </header>

    <main class="konten">
        @if (session('sukses'))
            <div class="alert alert-success">{{ session('sukses') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        @yield('content')
    </main>
</div>

<script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>