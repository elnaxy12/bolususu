<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $totalKategori     = Kategori::count();
        $totalDenganProduk = Kategori::has('produks')->count();
        $totalKosong       = Kategori::doesntHave('produks')->count();
        $kategoris         = Kategori::withCount('produks')->paginate(10);

        return view('backend.pages.kategori', compact(
            'kategoris', 'totalKategori', 'totalDenganProduk', 'totalKosong'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        Kategori::create($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('kelola-kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:kategoris,nama_kategori,' . $kategori->id_kategori . ',id_kategori',
            'deskripsi'     => 'nullable|string|max:500',
        ]);

        $kategori->update($request->only(['nama_kategori', 'deskripsi']));

        return redirect()->route('kelola-kategori')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return redirect()->route('kelola-kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}