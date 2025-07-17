<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'merk_type',
        'kategori_id',
        'jumlah',
        'satuan',
        'sumber_barang',
        'harga_barang',
        'keterangan',
        'stok',
        'status',
        'gambar',
    ];

    /**
     * Relasi ke Kategori (many-to-one)
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Relasi ke BarangMasuk (one-to-many)
     */
    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class);
    }

    /**
     * Relasi ke Bidang (many-to-many)
     */
    public function bidangs()
    {
        return $this->belongsToMany(Bidang::class, 'barang_bidang');
    }
}
