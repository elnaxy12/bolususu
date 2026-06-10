<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(['user', 'details.produk']);

        if ($request->filled('search')) {
            $query->where('id_transaksi', 'like', "%{$request->search}%");
        }

        if ($request->filled('metode')) {
            $query->where('metode_bayar', $request->metode);
        }

        if ($request->filled('dari')) {
            $query->whereDate('tanggal', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal', '<=', $request->sampai);
        }

        $transaksis     = $query->latest('tanggal')->paginate(10)->withQueryString();
        $totalTransaksi = Transaksi::count();
        $totalPendapatan = Transaksi::sum('total_harga');
        $hariIni        = Transaksi::whereDate('tanggal', today())->sum('total_harga');

        return view('backend.pages.riwayat', compact(
            'transaksis',
            'totalTransaksi',
            'totalPendapatan',
            'hariIni'
        ));
    }
}
