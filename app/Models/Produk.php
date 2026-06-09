<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $primaryKey = 'id_produk';

    protected $fillable = [
        'id_kategori', 'nama_produk', 'harga', 'satuan',
        'foto', 'status', 'jumlah_stok', 'stok_minimum',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function isStokRendah(): bool
    {
        return $this->jumlah_stok <= $this->stok_minimum;
    }
}