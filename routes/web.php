<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\KaryawanController;
use App\Http\Controllers\Backend\StokController;
use App\Http\Controllers\Backend\ProdukController;
use App\Http\Controllers\Backend\KategoriController;
use App\Http\Controllers\Backend\TransaksiController;
use App\Http\Controllers\Backend\RiwayatController;
use App\Http\Controllers\Backend\LaporanController;
use App\Http\Controllers\Backend\DashboardController;

// Home
Route::get('/', fn () => view('frontend.home.app'))->name('home');

// ─── Guest ─────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Authenticated ──────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Owner + Karyawan
    Route::get('/kelola-stok', [StokController::class, 'index'])->name('kelola-stok');
    Route::put('/kelola-stok/{produk}', [StokController::class, 'updateStok'])->name('stok.update');
    Route::get('/proses-transaksi', [TransaksiController::class, 'index'])->name('proses-transaksi');
    Route::post('/proses-transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/proses-transaksi/struk/{id}', [TransaksiController::class, 'struk'])->name('transaksi.struk');
    Route::get('/riwayat-transaksi', [RiwayatController::class, 'index'])->name('riwayat-transaksi');

    // Owner only
    Route::middleware('role:owner')->group(function () {
        Route::resource('kelola-karyawan', KaryawanController::class)
            ->parameters(['kelola-karyawan' => 'karyawan'])
            ->names('karyawan');

        // Laporan
        Route::get('/laporan-penjualan', [LaporanController::class, 'index'])->name('laporan-penjualan');
        Route::get('/laporan-penjualan/export', [LaporanController::class, 'export'])->name('laporan.export');

        // Produk
        Route::get('/kelola-produk', [ProdukController::class, 'index'])->name('kelola-produk');
        Route::post('/kelola-produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('/kelola-produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/kelola-produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        // Kategori
        Route::get('/kelola-kategori', [KategoriController::class, 'index'])->name('kelola-kategori');
        Route::post('/kelola-kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kelola-kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kelola-kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
});
