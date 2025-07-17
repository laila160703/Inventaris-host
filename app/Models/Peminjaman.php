<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Barang;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjamans'; // <== ini wajib ditambahkan

    protected $fillable = [
        'user_id', 'barang_id', 'jumlah',
        'tanggal_pinjam', 'tanggal_kembali', 'status', 'foto','kondisi_barang',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
