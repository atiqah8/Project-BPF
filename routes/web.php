<?php

use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\Admin;
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

// ===== Area pelanggan (harus login) =====
Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
    Route::post('/keranjang/{produk}', [KeranjangController::class, 'store'])->name('keranjang.store');
    Route::patch('/keranjang/{keranjang}', [KeranjangController::class, 'update'])->name('keranjang.update');
    Route::delete('/keranjang/{keranjang}', [KeranjangController::class, 'destroy'])->name('keranjang.destroy');
});

// ===== Panel karyawan =====
Route::prefix('admin')->group(function () {
    Route::get('/login', [KaryawanAuthController::class, 'showLogin'])
        ->name('karyawan.login')->middleware('guest:karyawan');
    Route::post('/login', [KaryawanAuthController::class, 'login'])->middleware('guest:karyawan');

    Route::middleware('auth:karyawan')->group(function () {
        Route::post('/logout', [KaryawanAuthController::class, 'logout'])->name('karyawan.logout');
        Route::get('/', [Admin\DashboardController::class, 'index'])->name('admin.dashboard');

        // Khusus admin
        Route::middleware('role:admin')->group(function () {
            Route::resource('kategori', Admin\KategoriController::class)
                ->except('show')->names('admin.kategori');
            Route::resource('produk', Admin\ProdukController::class)
                ->except('show')->names('admin.produk');
            Route::resource('karyawan', Admin\KaryawanController::class)
                ->except('show')->names('admin.karyawan');
        });
    });
});

Route::get('/cek-upload', function () {
    $tmp = ini_get('upload_tmp_dir') ?: sys_get_temp_dir();

    return response()->json([
        'php_ini_dipakai'     => php_ini_loaded_file(),
        'upload_tmp_dir'      => ini_get('upload_tmp_dir'),
        'folder_sementara'    => $tmp,
        'folder_ada'          => is_dir($tmp),
        'folder_bisa_ditulis' => is_writable($tmp),
        'file_uploads'        => ini_get('file_uploads'),
        'upload_max_filesize' => ini_get('upload_max_filesize'),
    ], 200, [], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
});