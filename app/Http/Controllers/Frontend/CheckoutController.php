<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang masih kosong');
        }

        $total = $items->sum(function ($item) {
            return $item->quantity * $item->produk->harga;
        });

        return view('frontend.customer.checkout', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_pengiriman' => 'required|string|max:500',
            'metode_bayar' => 'required|string',
        ]);

        $items = Keranjang::with('produk')
            ->where('user_id', Auth::id())
            ->get();

        if ($items->isEmpty()) {
            return redirect('/keranjang')->with('error', 'Keranjang masih kosong');
        }

        $pesanan = DB::transaction(function () use ($request, $items) {
            $total = $items->sum(function ($item) {
                return $item->quantity * $item->produk->harga;
            });

            $pesanan = Pesanan::create([
                'id_user' => Auth::id(),
                'status_pesanan' => 'pending',
                'metode_bayar' => $request->metode_bayar,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'tanggal_pesan' => now(),
                'total_harga' => $total,
            ]);

            foreach ($items as $item) {
                DetailPesanan::create([
                    'id_pesanan' => $pesanan->id_pesanan,
                    'id_produk' => $item->produk_id,
                    'jumlah' => $item->quantity,
                    'harga_satuan' => $item->produk->harga,
                    'subtotal' => $item->quantity * $item->produk->harga,
                ]);
            }

            // kosongkan keranjang setelah checkout
            Keranjang::where('user_id', Auth::id())->delete();

            return $pesanan;
        });

        return redirect()->route('pesanan.show', $pesanan->id_pesanan)
            ->with('success', 'Pesanan berhasil dibuat!');
    }
}
