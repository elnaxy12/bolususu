<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    public function index()
    {
        $produks = Produk::where('status', 'aktif')
                         ->where('jumlah_stok', '>', 0)
                         ->with('kategori')
                         ->get();

        return view('backend.pages.transaksi', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items'        => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produks,id_produk',
            'items.*.jumlah'    => 'required|integer|min:1',
            'metode_bayar' => 'required|in:tunai,transfer,qris',
            'bayar'        => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $total = 0;
            $items = [];

            foreach ($request->items as $item) {
                $produk = Produk::findOrFail($item['id_produk']);
                $subtotal = $produk->harga * $item['jumlah'];
                $total += $subtotal;

                $items[] = [
                    'id_produk'    => $produk->id_produk,
                    'jumlah'       => $item['jumlah'],
                    'harga_satuan' => $produk->harga,
                    'subtotal'     => $subtotal,
                ];

                // Kurangi stok
                $produk->decrement('jumlah_stok', $item['jumlah']);
            }

            $transaksi = Transaksi::create([
                'id_user'      => Auth::id(),
                'tanggal'      => now()->toDateString(),
                'total_harga'  => $total,
                'metode_bayar' => $request->metode_bayar,
                'bayar'        => $request->bayar,
                'kembalian'    => max(0, $request->bayar - $total),
            ]);

            foreach ($items as $item) {
                $transaksi->details()->create($item);
            }

            session(['last_transaksi_id' => $transaksi->id_transaksi]);
        });

        return response()->json(['success' => true, 'transaksi_id' => session('last_transaksi_id')]);
    }

    public function struk($id)
    {
        $transaksi = Transaksi::with(['details.produk', 'user'])->findOrFail($id);
        return response()->json($transaksi);
    }
}
