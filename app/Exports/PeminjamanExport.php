<?php

namespace App\Exports;

use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeminjamanExport implements FromCollection
{
    public function collection()
    {
        // Hanya data dari user yang sedang login (petugas)
        return Peminjaman::where('user_id', Auth::id())->with('barang')->get();
    }
}
