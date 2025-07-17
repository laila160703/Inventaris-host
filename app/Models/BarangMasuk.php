<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

   protected $fillable = [
    'kode_transaksi',
    'barang_id',
    'tanggal_masuk',
    'jumlah',
    'supplier',
    'keterangan',
];

public function barang()
{
    return $this->belongsTo(Barang::class);
}

}
