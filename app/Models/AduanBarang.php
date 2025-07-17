<?php

// app/Models/AduanBarang.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AduanBarang extends Model
{
    use HasFactory;

  protected $fillable = [
    'user_id',
    'barang_id',
    'jumlah',
    'jenis_aduan',
    'deskripsi',
    'tanggal_aduan',
    'foto',
    'status',
];

          public function barang()
  {
      return $this->belongsTo(Barang::class, 'barang_id');
  }

  public function user()
  {
      return $this->belongsTo(User::class);
  }

}



