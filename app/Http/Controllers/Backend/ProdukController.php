<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $totalProduk = \App\Models\Produk::count();
        $totalAktif = \App\Models\Produk::where('status', 'aktif')->count();
        $totalNonaktif  = \App\Models\Produk::where('status', 'nonaktif')->count(); 
        $produks = \App\Models\Produk::paginate(10);
        $kategoris = \App\Models\Kategori::all();

        return view('backend.pages.produk', compact('produks', 'totalProduk', 'totalAktif', 'totalNonaktif', 'kategoris'));
    }
}
