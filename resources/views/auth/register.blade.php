@extends('layouts.app')
@section('title', 'Daftar')

@section('content')
<section class="spad">
    <div class="container" style="max-width:420px">
        <h3 class="mb-4 text-center">Daftar</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <input name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" class="form-control" placeholder="Nama lengkap" required>
                @error('nama_pelanggan') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <input name="no_whatsapp" value="{{ old('no_whatsapp') }}" class="form-control" placeholder="No. WhatsApp (08xxxx)" required>
                @error('no_whatsapp') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password (min. 6 karakter)" required>
                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
            </div>
            <button class="btn btn-dark btn-block">Daftar</button>
            <p class="text-center mt-3">Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></p>
        </form>
    </div>
</section>
@endsection