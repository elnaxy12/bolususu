<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $totalKategori    = \App\Models\Kategori::count();
        $totalDenganProduk = \App\Models\Produk::has('kategori')->count();

        $totalKosong      = \App\Models\Kategori::doesntHave('produks')->count();
        $kategoris        = \App\Models\Kategori::withCount('produks')->paginate(10);

        return view('backend.pages.kategori', compact(
            'kategoris', 'totalKategori', 'totalDenganProduk', 'totalKosong'
        ));
    }
}
