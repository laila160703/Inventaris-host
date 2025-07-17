<?php

// app/Models/Kategori.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $fillable = ['nama'];

    /**
     * Relasi ke model Barang
     * Kategori has many Barang
     */
    public function barangs()
    {
        return $this->hasMany(Barang::class);
    }
}
