<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        $produks = [
            [
                'id_kategori'  => 1,
                'nama_produk'  => 'Alpukat Coklat',
                'foto'         => 'images/products/product-1.webp',
                'harga'        => 38000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 50,
                'stok_minimum' => 10,
            ],
            [
                'id_kategori'  => 1,
                'nama_produk'  => 'Black Forest',
                'foto'         => 'images/products/product-2.webp',
                'harga'        => 38000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 50,
                'stok_minimum' => 10,
            ],
            [
                'id_kategori'  => 1,
                'nama_produk'  => 'Cheese Cake',
                'foto'         => 'images/products/product-3.webp',
                'harga'        => 38000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 50,
                'stok_minimum' => 10,
            ],
            [
                'id_kategori'  => 2,
                'nama_produk'  => 'Bolu Gulung Susu Rasa Coklat',
                'foto'         => 'images/products/product-4.png',
                'harga'        => 46000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 30,
                'stok_minimum' => 5,
            ],
            [
                'id_kategori'  => 2,
                'nama_produk'  => 'Bolu Gulung Susu Rasa Keju',
                'foto'         => 'images/products/product-5.png',
                'harga'        => 46000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 30,
                'stok_minimum' => 5,
            ],
            [
                'id_kategori'  => 3,
                'nama_produk'  => 'Cokelat Mini Pack',
                'foto'         => 'images/products/product-6.jpg',
                'harga'        => 20000,
                'satuan'       => 'pcs',
                'status'       => 'aktif',
                'jumlah_stok'  => 100,
                'stok_minimum' => 20,
            ],
        ];

        foreach ($produks as $produk) {
            Produk::create($produk);
        }
    }
}