<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;

class LaporanController extends Controller
{
    // Gabungan laporan masuk & keluar
        public function index(Request $request)
    {
        // Ambil filter barang masuk
        $bulanMasuk = $request->input('bulan_masuk');
        $tahunMasuk = $request->input('tahun_masuk');

        // Ambil filter barang keluar
        $bulanKeluar = $request->input('bulan_keluar');
        $tahunKeluar = $request->input('tahun_keluar');

        // Query Barang Masuk
        $barangMasuks = BarangMasuk::with('barang')
            ->when($bulanMasuk, fn ($q) => $q->whereMonth('tanggal_masuk', $bulanMasuk))
            ->when($tahunMasuk, fn ($q) => $q->whereYear('tanggal_masuk', $tahunMasuk))
            ->get();

        // Query Barang Keluar
        $barangKeluars = BarangKeluar::with(['barang', 'bidang']) // jika ada relasi bidang
            ->when($bulanKeluar, fn ($q) => $q->whereMonth('tanggal_keluar', $bulanKeluar))
            ->when($tahunKeluar, fn ($q) => $q->whereYear('tanggal_keluar', $tahunKeluar))
            ->get();

        return view('admin.laporan.laporan', compact(
            'barangMasuks',
            'barangKeluars',
            'bulanMasuk',
            'tahunMasuk',
            'bulanKeluar',
            'tahunKeluar'
        ));
    }


    // Khusus Barang Masuk
    public function barangMasuk(Request $request)
    {
        $query = BarangMasuk::with('barang');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_masuk', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_masuk', $request->tahun);
        }

        $barangMasuks = $query->get();

        // Perlu juga mengambil data keluar agar tidak error di view
        $barangKeluars = BarangKeluar::with('barang')->get();

        return view('admin.laporan.laporan', compact('barangMasuks', 'barangKeluars'));
    }

    // Khusus Barang Keluar
    public function barangKeluar(Request $request)
    {
        $query = BarangKeluar::with('barang');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal_keluar', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('tanggal_keluar', $request->tahun);
        }

        $barangKeluars = $query->get();

        // Perlu juga mengambil data masuk agar tidak error di view
        $barangMasuks = BarangMasuk::with('barang')->get();

        return view('admin.laporan.laporan', compact('barangKeluars', 'barangMasuks'));
    }
}
