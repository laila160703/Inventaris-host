<?php
namespace App\Imports;

use App\Models\Barang;
use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        $kategori = Kategori::firstOrCreate(['nama' => $row['kategori_id']]);

        return new Barang([
            'kode_barang'   => $row['kode_barang'],
            'nama_barang'   => $row['nama_barang'],
            'kategori_id'   => $kategori->id,
            'merk_type'     => $row['merk_type'],
            'jumlah'        => $row['jumlah'],
            'satuan'        => $row['satuan'],
            'asal_barang'   => $row['asal_barang'],
            'harga_barang'  => $row['harga_barang'],
            'keterangan'    => $row['keterangan'],
        ]);
    }
}
