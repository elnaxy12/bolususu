<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';

    protected $fillable = [
        'id_user', 'status_pesanan', 'metode_bayar',
        'alamat_pengiriman', 'tanggal_pesan', 'total_harga',
    ];

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}

