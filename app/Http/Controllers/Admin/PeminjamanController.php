<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Barang;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['barang', 'user']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $ajuan = $query->latest()->paginate(10);

        return view('admin.peminjaman.index', compact('ajuan'));
    }

    public function terima($id)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Ajuan sudah pernah diproses.');
        }

        $barang = $peminjaman->barang;

        if (!$barang) {
            return back()->with('error', 'Data barang tidak ditemukan.');
        }

        if ($barang->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok barang tidak mencukupi.');
        }

        $barang->decrement('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'Dipinjam',
            'tanggal_disetujui' => now(),
        ]);

        return back()->with('success', 'Ajuan peminjaman disetujui.');
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'Menunggu') {
            return back()->with('error', 'Ajuan sudah diproses.');
        }

        $peminjaman->update(['status' => 'Ditolak']);

        return back()->with('success', 'Ajuan peminjaman ditolak.');
    }

    public function verifikasiForm($id)
    {
        $peminjaman = Peminjaman::with('user', 'barang')->findOrFail($id);
        return view('admin.peminjaman.verifikasi', compact('peminjaman'));
    }

    public function verifikasiPengembalian(Request $request, $id)
{
    $request->validate([
        'tanggal_kembali' => 'required|date',
        'kondisi_barang' => 'required|string|max:255',
    ]);

    $peminjaman = Peminjaman::with('barang')->findOrFail($id);

    if ($peminjaman->status !== 'Menunggu Verifikasi') {
        return redirect()->back()->with('error', 'Peminjaman tidak perlu diverifikasi.');
    }

    $peminjaman->update([
        'tanggal_kembali' => $request->tanggal_kembali,
        'kondisi_barang' => $request->kondisi_barang,
        'status' => 'Dikembalikan',
    ]);

    // Tambah stok jika barang dalam kondisi baik
    if (strtolower($request->kondisi_barang) === 'baik') {
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);
    }

    return redirect()->route('admin.peminjaman.index')->with('success', 'Pengembalian diverifikasi.');
}

}
