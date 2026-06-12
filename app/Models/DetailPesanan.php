<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    protected $primaryKey = 'id_detail_pesanan';

    protected $fillable = [
        'id_pesanan', 'id_produk', 'jumlah', 'harga_satuan', 'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(\App\Models\Produk::class, 'id_produk', 'id_produk');
    }
}

