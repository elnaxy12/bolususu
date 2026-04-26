<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $fillable = [
    'nama', 'nip', 'email', 'telepon',
    'departemen', 'jabatan', 'tanggal_masuk',
    'status', 'alamat', 'foto',
    ];
}
