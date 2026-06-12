<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;


class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::where('id_user', auth()->id())
            ->latest()
            ->get();

        return view('frontend.customer.pesanan', compact('pesanan'));
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('detailPesanan.produk')
            ->where('id_pesanan', $id)
            ->where('id_user', auth()->id())
            ->firstOrFail();

        return view('frontend.customer.pesanan-detail', compact('pesanan'));
    }
}
