<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Karyawan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Stats owner
        $pendapatanHariIni  = Transaksi::whereDate('tanggal', today())->sum('total_harga');
        $transaksiHariIni   = Transaksi::whereDate('tanggal', today())->count();
        $totalKaryawan      = Karyawan::where('status', 'aktif')->count();
        $stokHampirHabis    = Produk::whereColumn('jumlah_stok', '<=', 'stok_minimum')->where('jumlah_stok', '>', 0)->count();

        // Stats karyawan
        $transaksiSaya      = Transaksi::whereDate('tanggal', today())->where('id_user', $user->id_user)->count();
        $itemTerjualHariIni = DetailTransaksi::whereHas(
            'transaksi',
            fn ($q) =>
            $q->whereDate('tanggal', today())
        )->sum('jumlah');
        $strukDicetak       = $transaksiHariIni;

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with(['details.produk', 'user'])
            ->latest()
            ->limit(5)
            ->get();

        // Monitor stok
        $monitorStok = Produk::where('status', 'aktif')
            ->orderByRaw('jumlah_stok / NULLIF(stok_minimum, 0) ASC')
            ->limit(5)
            ->get();

        // Grafik 7 hari
        $grafik7Hari = collect(range(6, 0))->map(function ($i) {
            $tanggal = now()->subDays($i)->toDateString();
            return [
                'hari'  => now()->subDays($i)->locale('id')->isoFormat('ddd'),
                'total' => Transaksi::whereDate('tanggal', $tanggal)->sum('total_harga'),
            ];
        });

        $maxGrafik = $grafik7Hari->max('total') ?: 1;

        return view('backend.pages.dashboard', compact(
            'pendapatanHariIni',
            'transaksiHariIni',
            'totalKaryawan',
            'stokHampirHabis',
            'transaksiSaya',
            'itemTerjualHariIni',
            'strukDicetak',
            'transaksiTerbaru',
            'monitorStok',
            'grafik7Hari',
            'maxGrafik'
        ));
    }
}
