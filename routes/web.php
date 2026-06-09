<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\StokController;

// Home
Route::get('/', fn () => view('frontend.home.app'))->name('home');


// ─── Guest routes (belum login) ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Authenticated routes ───────────────────────────────────────────────────


Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => view('backend.pages.dashboard'))->name('dashboard');

    // Owner + Karyawan
    Route::get('/kelola-stok', [StokController::class, 'index'])->name('kelola-stok');
    Route::put('/kelola-stok/{produk}', [StokController::class, 'updateStok'])->name('stok.update');
    Route::get('/proses-transaksi', fn () => view('backend.pages.transaksi'))->name('proses-transaksi');
    Route::get('/riwayat-transaksi', fn () => view('backend.pages.riwayat'))->name('riwayat-transaksi');

    // Owner only
    Route::middleware('role:owner')->group(function () {
        Route::resource('kelola-karyawan', KaryawanController::class)
            ->parameters(['kelola-karyawan' => 'karyawan'])
            ->names('karyawan');
        Route::get('/laporan-penjualan', fn () => view('backend.pages.laporan'))->name('laporan-penjualan');
        Route::get('/kelola-produk', fn () => view('backend.pages.produk'))->name('kelola-produk');
        Route::get('/kelola-kategori', fn () => view('backend.pages.kategori'))->name('kelola-kategori');
    });
});

