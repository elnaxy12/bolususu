<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    public function index()
    {
        $items = Keranjang::with('produk')
            ->where('user_id', auth()->id())
            ->get();

        return view('frontend.customer.home', compact('items'));
    }

    public function tambah(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id_produk',
            'quantity'  => 'required|integer|min:1',
        ]);

        $item = Keranjang::where('user_id', auth()->id())
            ->where('produk_id', $request->produk_id)
            ->first();

        if ($item) {
            $item->increment('quantity', $request->quantity);
        } else {
            Keranjang::create([
                'user_id'   => auth()->id(),
                'produk_id' => $request->produk_id,
                'quantity'  => $request->quantity,
            ]);
        }

        return response()->json(['success' => true]);
    }

    public function data()
    {
        $items = Keranjang::where('user_id', auth()->id())->get();
        return response()->json($items);
    }

    public function update(Request $request, $produk_id)
    {
        Keranjang::where('user_id', auth()->id())
            ->where('produk_id', $produk_id)
            ->update(['quantity' => $request->quantity]);

        return response()->json(['success' => true]);
    }

    public function hapus($produk_id)
    {
        Keranjang::where('user_id', auth()->id())
            ->where('produk_id', $produk_id)
            ->delete();

        return response()->json(['success' => true]);
    }

    // Dipanggil tepat setelah login — merge localStorage → DB
    public function merge(Request $request)
    {
        
        if (!auth()->check()) {
            return response()->json(['success' => false], 401);
        }

        $items = $request->input('items', []);

        foreach ($items as $item) {
            if (empty($item['produk_id']) || empty($item['quantity'])) {
                continue;
            }

            $existing = Keranjang::where('user_id', auth()->id())
                ->where('produk_id', $item['produk_id'])
                ->first();

            if ($existing) {
                $existing->increment('quantity', $item['quantity']);
            } else {
                Keranjang::create([
                    'user_id'   => auth()->id(),
                    'produk_id' => $item['produk_id'],
                    'quantity'  => $item['quantity'],
                ]);
            }
        }

        return response()->json(['success' => true]);
    }
}
