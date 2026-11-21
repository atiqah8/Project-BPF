@extends('layouts.app')
@section('title', 'Masuk')

@section('content')
<section class="spad">
    <div class="container" style="max-width:420px">
        <h3 class="mb-4 text-center">Masuk</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="Email" required>
                @error('email') <small class="text-danger">{{ $message }}</small> @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <div class="form-check mb-3">
                <input type="checkbox" name="ingat" value="1" id="ingat" class="form-check-input">
                <label for="ingat" class="form-check-label">Ingat saya</label>
            </div>
            <button class="btn btn-dark btn-block">Masuk</button>
            <p class="text-center mt-3">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
        </form>
    </div>
</section>
@endsection