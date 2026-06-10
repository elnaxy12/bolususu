<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $query = Transaksi::whereBetween('tanggal', [$dari, $sampai]);

        // Stat
        $totalPendapatan = (clone $query)->sum('total_harga');
        $totalTransaksi  = (clone $query)->count();
        $rataRata        = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Grafik per hari
        $grafikHarian = (clone $query)
            ->selectRaw('tanggal, SUM(total_harga) as total')
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Rekap metode bayar
        $rekapMetode = (clone $query)
            ->selectRaw('metode_bayar, COUNT(*) as jumlah, SUM(total_harga) as total')
            ->groupBy('metode_bayar')
            ->get();

        // Produk terlaris
        $produkTerlaris = DetailTransaksi::with('produk')
            ->whereHas('transaksi', fn($q) => $q->whereBetween('tanggal', [$dari, $sampai]))
            ->selectRaw('id_produk, SUM(jumlah) as total_terjual, SUM(subtotal) as total_pendapatan')
            ->groupBy('id_produk')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Tabel transaksi
        $transaksis = (clone $query)->latest('tanggal')->paginate(10)->withQueryString();

        return view('backend.pages.laporan', compact(
            'dari', 'sampai',
            'totalPendapatan', 'totalTransaksi', 'rataRata',
            'grafikHarian', 'rekapMetode', 'produkTerlaris', 'transaksis'
        ));
    }

    public function export(Request $request)
    {
        $dari   = $request->dari   ?? now()->startOfMonth()->toDateString();
        $sampai = $request->sampai ?? now()->toDateString();

        $transaksis = Transaksi::with(['details.produk', 'user'])
            ->whereBetween('tanggal', [$dari, $sampai])
            ->latest('tanggal')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="laporan_' . $dari . '_' . $sampai . '.csv"',
        ];

        $callback = function () use ($transaksis) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            fputcsv($file, ['No', 'No. Transaksi', 'Tanggal', 'Kasir', 'Item', 'Metode', 'Total', 'Bayar', 'Kembalian']);

            foreach ($transaksis as $i => $t) {
                $items = $t->details->map(fn($d) => $d->produk->nama_produk . ' x' . $d->jumlah)->join(', ');
                fputcsv($file, [
                    $i + 1,
                    '#' . str_pad($t->id_transaksi, 5, '0', STR_PAD_LEFT),
                    $t->tanggal,
                    $t->user->nama ?? '—',
                    $items,
                    ucfirst($t->metode_bayar),
                    $t->total_harga,
                    $t->bayar,
                    $t->kembalian,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}