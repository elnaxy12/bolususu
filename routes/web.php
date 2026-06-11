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
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\KeranjangController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\PesananController;

// ─── Guest ─────────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');


// ─── Authenticated (semua role) ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ─── Backend (owner + karyawan) ─────────────────────────────────────────────
Route::middleware(['auth', 'role:owner,karyawan'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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

        Route::get('/laporan-penjualan', [LaporanController::class, 'index'])->name('laporan-penjualan');
        Route::get('/laporan-penjualan/export', [LaporanController::class, 'export'])->name('laporan.export');

        Route::get('/kelola-produk', [ProdukController::class, 'index'])->name('kelola-produk');
        Route::post('/kelola-produk', [ProdukController::class, 'store'])->name('produk.store');
        Route::put('/kelola-produk/{produk}', [ProdukController::class, 'update'])->name('produk.update');
        Route::delete('/kelola-produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

        Route::get('/kelola-kategori', [KategoriController::class, 'index'])->name('kelola-kategori');
        Route::post('/kelola-kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kelola-kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kelola-kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');
    });
});


// ─── Frontend Customer ───────────────────────────────────────────────────────
Route::get('/', [CustomerController::class, 'home']);
Route::get('/produk', [CustomerController::class, 'produk']);

// Keranjang guest (tidak butuh auth)
Route::post('/keranjang/merge', [KeranjangController::class, 'merge']); // ← tambah ini

Route::middleware(['auth', 'role:customer'])->group(function () {
    Route::get('/keranjang', [KeranjangController::class, 'index']);
    
Route::get('/keranjang/data', [KeranjangController::class, 'data']);

    Route::post('/keranjang/tambah', [KeranjangController::class, 'tambah']);
    Route::put('/keranjang/{id}', [KeranjangController::class, 'update']);    // ← tambah
    Route::delete('/keranjang/{id}', [KeranjangController::class, 'hapus']); // ← tambah
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout', [CheckoutController::class, 'store']);
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
});

