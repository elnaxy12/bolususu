<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $totalProduk   = Produk::count();
        $totalAktif    = Produk::where('status', 'aktif')->count();
        $totalNonaktif = Produk::where('status', 'nonaktif')->count();
        $produks       = Produk::with('kategori')->paginate(10);
        $kategoris     = Kategori::all();

        return view('backend.pages.produk', compact(
            'produks', 'totalProduk', 'totalAktif', 'totalNonaktif', 'kategoris'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'harga'       => 'required|numeric|min:0',
            'satuan'      => 'required|string|max:50',
            'status'      => 'required|in:aktif,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'id_kategori', 'harga', 'satuan', 'status']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        Produk::create($data);

        return redirect()->route('kelola-produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'harga'       => 'required|numeric|min:0',
            'satuan'      => 'required|string|max:50',
            'status'      => 'required|in:aktif,nonaktif',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = $request->only(['nama_produk', 'id_kategori', 'harga', 'satuan', 'status']);

        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($produk->foto) {
                \Storage::disk('public')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'public');
        }

        $produk->update($data);

        return redirect()->route('kelola-produk')->with('success', 'Produk berhasil diperbarui.');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto) {
            \Storage::disk('public')->delete($produk->foto);
        }

        $produk->delete();

        return redirect()->route('kelola-produk')->with('success', 'Produk berhasil dihapus.');
    }
}