<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BarangBidang extends Model
{
    protected $table = 'barang_bidang'; // Wajib, karena pakai underscore

    protected $fillable = [
        'barang_id',
        'bidang_id',
        'jumlah',
    ];

    public function barang()
    {
        return $this->belongsTo(\App\Models\Barang::class);
    }


    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }
}
