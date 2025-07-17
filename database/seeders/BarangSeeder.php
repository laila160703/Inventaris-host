<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Kategori;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $barang = Barang::create([
            'kode_barang'    => '01.01.01.04.001',
            'nama_barang'    => 'Laptop ASUS',
            'merk_type'      => 'ASUS X441U',
            'jumlah'         => 5,
            'stok'           => 5,
            'satuan'         => 'unit',
            'sumber_barang'  => 'Pengadaan',
            'harga_barang'   => 7000000,
            'kategori_id'    => 1,
            'status'         => 'tersedia',
        ]);

        // Hubungkan barang ini ke bidang dengan ID 1 dan 2
        $barang->bidangs()->attach([1, 2]);
    }
}
