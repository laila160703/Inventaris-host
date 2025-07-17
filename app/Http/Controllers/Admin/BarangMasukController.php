<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Http\Request;

class BarangMasukController extends Controller
{
    public function index(Request $request)
    {
        $query = BarangMasuk::with('barang');

        if ($request->filled('search')) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_masuk', $request->tanggal);
        }

        $barangMasuks = $query->orderBy('tanggal_masuk', 'desc')->paginate(10);

        return view('admin.barang-masuk.index', compact('barangMasuks'));
    }

    public function create()
    {
        $barangs = Barang::all();

        $tanggal = now()->format('Ymd');
        $count = BarangMasuk::whereDate('created_at', now())->count() + 1;
        $kode_transaksi = 'BM-' . $tanggal . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        return view('admin.barang-masuk.create', [
            'barangs' => $barangs,
            'kode_transaksi' => $kode_transaksi,
            'barangMasuks' => BarangMasuk::latest()->take(5)->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'supplier' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $tanggal = now()->format('Ymd');
        $count = BarangMasuk::whereDate('created_at', now())->count() + 1;
        $kodeTransaksi = 'BM-' . $tanggal . '-' . str_pad($count, 3, '0', STR_PAD_LEFT);

        $barangMasuk = BarangMasuk::create([
            'kode_transaksi' => $kodeTransaksi,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        // Tambah stok dan jumlah barang
        $barang = Barang::find($request->barang_id);
        $barang->stok += $request->jumlah;
        $barang->jumlah += $request->jumlah;
        $barang->save();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Barang masuk berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);
        $barangs = Barang::all();

        return view('admin.barang-masuk.edit', compact('barangMasuk', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'supplier' => 'required|string|max:100',
            'keterangan' => 'nullable|string',
        ]);

        // Kurangi stok dan jumlah lama
        $barangLama = Barang::find($barangMasuk->barang_id);
        $barangLama->stok -= $barangMasuk->jumlah;
        $barangLama->jumlah -= $barangMasuk->jumlah;
        $barangLama->save();

        // Update data barang masuk
        $barangMasuk->update([
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_masuk' => $request->tanggal_masuk,
            'supplier' => $request->supplier,
            'keterangan' => $request->keterangan,
        ]);

        // Tambah stok dan jumlah baru
        $barangBaru = Barang::find($request->barang_id);
        $barangBaru->stok += $request->jumlah;
        $barangBaru->jumlah += $request->jumlah;
        $barangBaru->save();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Data barang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barangMasuk = BarangMasuk::findOrFail($id);

        $barang = Barang::find($barangMasuk->barang_id);
        $barang->stok -= $barangMasuk->jumlah;
        $barang->jumlah -= $barangMasuk->jumlah;
        $barang->save();

        $barangMasuk->delete();

        return redirect()->route('admin.barang-masuk.index')->with('success', 'Data barang masuk dihapus.');
    }
}
