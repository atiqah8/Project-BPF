<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Karyawan</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light">
<div class="container" style="max-width:380px; margin-top:12vh">
    <div class="card"><div class="card-body">
        <h4 class="mb-3">Login Karyawan</h4>
        <form method="POST" action="{{ route('karyawan.login') }}">
            @csrf
            <div class="form-group">
                <input name="username" value="{{ old('username') }}" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            @error('username') <div class="text-danger mb-2">{{ $message }}</div> @enderror
            <button class="btn btn-dark btn-block">Masuk</button>
        </form>
    </div></div>
</div>
</body>
</html>