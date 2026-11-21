<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="p-4">
    <h4>Halo, {{ auth('karyawan')->user()->nama_lengkap }} ({{ auth('karyawan')->user()->role }})</h4>
    <p>Panel akan dilengkapi di tahap berikutnya.</p>
    <form method="POST" action="{{ route('karyawan.logout') }}">
        @csrf <button class="btn btn-outline-dark">Logout</button>
    </form>
</body>
</html>