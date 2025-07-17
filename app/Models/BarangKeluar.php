<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class BarangKeluar extends Model
{
    protected $fillable = [
        'kode_transaksi',
        'barang_id',
        'tanggal_keluar',
        'jumlah',
        'penerima', // ini menyimpan id dari bidang
        'keterangan',
    ];

    // Relasi ke Barang
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    // ✅ Tambahkan relasi ke Bidang
    public function bidang()
    {
        return $this->belongsTo(Bidang::class, 'penerima');
    }
}
