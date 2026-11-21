<?php

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\KaryawanAuthController;
use App\Http\Controllers\KatalogController;
use App\Http\Controllers\PelangganAuthController;
use Illuminate\Support\Facades\Route;

// ===== Publik =====
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/produk', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/produk/{produk}', [KatalogController::class, 'show'])->name('katalog.show');

// ===== Login pelanggan =====
Route::middleware('guest:pelanggan')->group(function () {
    Route::get('/masuk', [PelangganAuthController::class, 'showLogin'])->name('login');
    Route::post('/masuk', [PelangganAuthController::class, 'login']);
    Route::get('/daftar', [PelangganAuthController::class, 'showRegister'])->name('register');
    Route::post('/daftar', [PelangganAuthController::class, 'register']);
});
Route::post('/keluar', [PelangganAuthController::class, 'logout'])->name('logout');

// ===== Panel karyawan =====
Route::prefix('admin')->group(function () {
    Route::get('/login', [KaryawanAuthController::class, 'showLogin'])
        ->name('karyawan.login')->middleware('guest:karyawan');
    Route::post('/login', [KaryawanAuthController::class, 'login'])->middleware('guest:karyawan');

    Route::middleware('auth:karyawan')->group(function () {
        Route::post('/logout', [KaryawanAuthController::class, 'logout'])->name('karyawan.logout');
        Route::get('/', fn () => view('admin.dashboard'))->name('admin.dashboard');
    });
});