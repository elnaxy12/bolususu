<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class StokController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with('kategori');

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'rendah') {
                $query->whereColumn('jumlah_stok', '<=', 'stok_minimum');
            } else {
                $query->where('status', $request->status);
            }
        }

        $produks = $query->latest('updated_at')->paginate(10)->withQueryString();

        $totalProduk    = Produk::count();
        $stokRendah     = Produk::whereColumn('jumlah_stok', '<=', 'stok_minimum')->count();
        $totalStokHabis = Produk::where('jumlah_stok', 0)->count();

        return view('backend.pages.stok', compact('produks', 'totalProduk', 'stokRendah', 'totalStokHabis'));
    }

    public function updateStok(Request $request, Produk $produk)
    {
        $request->validate([
            'jumlah_stok'  => 'required|integer|min:0',
            'stok_minimum' => 'required|integer|min:0',
        ]);

        $produk->update([
            'jumlah_stok'  => $request->jumlah_stok,
            'stok_minimum' => $request->stok_minimum,
        ]);

        return redirect()->route('kelola-stok')
                         ->with('success', "Stok {$produk->nama_produk} berhasil diperbarui.");
    }
}
