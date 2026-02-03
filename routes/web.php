<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TranController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\RekapController;
use App\Http\Controllers\StrukController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB ROUTES
|--------------------------------------------------------------------------
*/

// ===================
// AUTH
// ===================
Route::get('/', function () {
    return view('kasir.login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');


// ===================
// KASIR (Protected)
// ===================
Route::middleware('auth:admin')->group(function () {
    // Dashboard
    Route::get('/dash', function () {
        return view('kasir.dashboard');
    })->name('kasir.dashboard');
    Route::get('/dash', [RekapController::class, 'index'])
    ->name('rekap.index');

    // ===================
    // PRODUK
    // ===================
    Route::get('/produk', [BarangController::class, 'index'])->name('produk.index');
    Route::post('/produk', [BarangController::class, 'store'])->name('produk.store');
    Route::get('/produk/{id}/edit', [BarangController::class, 'edit'])->name('produk.edit');
    Route::put('/produk/{id}', [BarangController::class, 'update'])->name('produk.update');
    Route::delete('/produk/{id}', [BarangController::class, 'destroy'])->name('produk.destroy');

    // ===================
    // TRANSAKSI
    // ===================
    Route::get('/tran', [TranController::class, 'index'])->name('transaksi.index');
    Route::post('/tran', [TranController::class, 'store'])->name('transaksi.store');

    // Keranjang
    Route::post('/keranjang/tambah', [TranController::class, 'tambahKeranjang'])
        ->name('keranjang.tambah');
    Route::delete('/keranjang/hapus/{id}', [TranController::class, 'hapusKeranjang'])
        ->name('keranjang.hapus');
    Route::post('/transaksi/simpan', [TranController::class, 'simpan'])
        ->name('transaksi.simpan');

    // ===================
    // REKAP / PELANGGAN
    // ===================
    Route::get('/rekap', [PelangganController::class, 'index'])->name('pelanggan.index');
    Route::delete('/rekap/{id}', [PelangganController::class, 'destroy'])->name('pelanggan.destroy');

    // donwload struk
    Route::get('/struk/{kode}/download', [StrukController::class, 'download'])
    ->name('struk.download');
});
