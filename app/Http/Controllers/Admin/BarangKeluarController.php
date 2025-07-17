<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangBidang;
use App\Models\Bidang;
use Illuminate\Http\Request;

class BarangKeluarController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangKeluar::with(['barang', 'bidang']);

        if ($request->filled('search')) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_keluar', $request->tanggal);
        }

        $barangKeluars = $query->orderBy('tanggal_keluar', 'desc')->paginate(10);
        return view('admin.barang-keluar.index', compact('barangKeluars'));
    }

    public function create()
    {
        $barangs = Barang::all();
        $bidangs = Bidang::all();

        $tanggal = now()->format('Ymd');
        $count = BarangKeluar::whereDate('created_at', now())->count() + 1;
        $kode_transaksi = 'BK-' . $tanggal . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('admin.barang-keluar.create', compact('barangs', 'bidangs', 'kode_transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_transaksi' => 'required|unique:barang_keluars,kode_transaksi',
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|exists:bidangs,id',
            'keterangan' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        // Simpan barang keluar
        $barangKeluar = BarangKeluar::create([
            'kode_transaksi' => $request->kode_transaksi,
            'barang_id' => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah' => $request->jumlah,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok utama
        $barang->stok -= $request->jumlah;
        $barang->save();

        // Tambah ke bidang
        $barangBidang = BarangBidang::firstOrNew([
            'barang_id' => $request->barang_id,
            'bidang_id' => $request->penerima,
        ]);
        $barangBidang->jumlah += $request->jumlah;
        $barangBidang->save();

        return redirect()->route('admin.barang-keluar.index')->with('success', 'Barang keluar berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barangs = Barang::all();
        $bidangs = Bidang::all();

        return view('admin.barang-keluar.edit', compact('barangKeluar', 'barangs', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'tanggal_keluar' => 'required|date',
            'jumlah' => 'required|integer|min:1',
            'penerima' => 'required|exists:bidangs,id',
            'keterangan' => 'nullable|string',
        ]);

        // Kembalikan stok lama
        $barangLama = Barang::find($barangKeluar->barang_id);
        $barangLama->stok += $barangKeluar->jumlah;
        $barangLama->save();

        // Kurangi dari barang_bidang lama
        $barangBidangLama = BarangBidang::where('barang_id', $barangKeluar->barang_id)
            ->where('bidang_id', $barangKeluar->penerima)
            ->first();
        if ($barangBidangLama) {
            $barangBidangLama->jumlah = max(0, $barangBidangLama->jumlah - $barangKeluar->jumlah);
            $barangBidangLama->save();
        }

        $barangBaru = Barang::findOrFail($request->barang_id);
        if ($barangBaru->stok < $request->jumlah) {
            return back()->withErrors(['jumlah' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        // Update data
        $barangKeluar->update([
            'barang_id' => $request->barang_id,
            'tanggal_keluar' => $request->tanggal_keluar,
            'jumlah' => $request->jumlah,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok baru
        $barangBaru->stok -= $request->jumlah;
        $barangBaru->save();

        // Tambah ke bidang baru
        $barangBidangBaru = BarangBidang::firstOrNew([
            'barang_id' => $request->barang_id,
            'bidang_id' => $request->penerima,
        ]);
        $barangBidangBaru->jumlah += $request->jumlah;
        $barangBidangBaru->save();

        return redirect()->route('admin.barang-keluar.index')->with('success', 'Data barang keluar berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangKeluar = BarangKeluar::findOrFail($id);
        $barang = Barang::findOrFail($barangKeluar->barang_id);

        // Kembalikan stok utama
        $barang->stok += $barangKeluar->jumlah;
        $barang->save();

        // Kurangi dari bidang
        $barangBidang = BarangBidang::where('barang_id', $barangKeluar->barang_id)
            ->where('bidang_id', $barangKeluar->penerima)
            ->first();

        if ($barangBidang) {
            $barangBidang->jumlah = max(0, $barangBidang->jumlah - $barangKeluar->jumlah);
            $barangBidang->save();
        }

        $barangKeluar->delete();

        return redirect()->route('admin.barang-keluar.index')->with('success', 'Data barang keluar berhasil dihapus.');
    }
}
