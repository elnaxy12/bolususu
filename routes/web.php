<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Backend\KaryawanController;
use Illuminate\Support\Facades\Route;

// ─── Guest routes (belum login) ────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// ─── Authenticated routes ───────────────────────────────────────────────────

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('backend.pages.dashboard');
    })->name('dashboard');

    // Manajemen
    Route::resource('kelola-karyawan', KaryawanController::class)
         ->parameters(['kelola-karyawan' => 'karyawan'])
         ->names('karyawan');

    Route::get('/laporan-penjualan', function () {
        return view('backend.pages.laporan');
    })->name('laporan-penjualan');

    // Produk & Stok
    Route::get('/kelola-produk', function () {
        return view('backend.pages.produk');
    })->name('kelola-produk');

    Route::get('/kelola-stok', function () {
        return view('backend.pages.stok');
    })->name('kelola-stok');

    Route::get('/kelola-kategori', function () {
        return view('backend.pages.kategori');
    })->name('kelola-kategori');

    // Transaksi
    Route::get('/proses-transaksi', function () {
        return view('backend.pages.transaksi');
    })->name('proses-transaksi');

    Route::get('/riwayat-transaksi', function () {
        return view('backend.pages.riwayat');
    })->name('riwayat-transaksi');
});
