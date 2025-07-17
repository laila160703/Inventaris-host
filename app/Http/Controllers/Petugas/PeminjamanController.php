<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;
use App\Models\Barang;
use App\Exports\PeminjamanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
        public function index(Request $request)
    {
        $userId = Auth::id();

        $query = Peminjaman::with(['barang', 'user'])
            ->where('user_id', $userId);

        // Filter berdasarkan barang
        if ($request->filled('barang_id')) {
            $query->where('barang_id', $request->barang_id);
        }

        // Filter berdasarkan tanggal pinjam
        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal_pinjam', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        // Filter berdasarkan tanggal kembali
        if ($request->filled('tanggal_kembali_awal') && $request->filled('tanggal_kembali_akhir')) {
            $query->whereBetween('tanggal_kembali', [$request->tanggal_kembali_awal, $request->tanggal_kembali_akhir]);
        }

        $barangs = Barang::all(); // untuk dropdown filter barang
        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->paginate(10);

        return view('petugas.peminjaman.index', compact('peminjaman', 'barangs'));
    }


    public function create()
    {
        $barangs = Barang::all();
        return view('petugas.peminjaman.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jumlah > $barang->stok) {
            return redirect()->back()->withInput()->withErrors([
                'jumlah' => 'Jumlah melebihi stok tersedia (' . $barang->stok . ')'
            ]);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('peminjaman_foto', 'public');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => $request->tanggal_pinjam,
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'Menunggu',
            'foto' => $fotoPath,
        ]);

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Ajuan peminjaman berhasil dikirim.');
    }

    public function edit($id)
    {
        $userId = Auth::id();
        $peminjaman = Peminjaman::where('id', $id)->where('user_id', $userId)->firstOrFail();
        $barangs = Barang::all();
        return view('petugas.peminjaman.edit', compact('peminjaman', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id();
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam',
            'status' => 'required|in:Dipinjam,Dikembalikan',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $peminjaman = Peminjaman::where('id', $id)->where('user_id', $userId)->firstOrFail();

        $fotoPath = $peminjaman->foto;
        if ($request->hasFile('foto')) {
            if ($fotoPath && Storage::disk('public')->exists($fotoPath)) {
                Storage::disk('public')->delete($fotoPath);
            }
            $fotoPath = $request->file('foto')->store('peminjaman_foto', 'public');
        }

       $peminjaman->update([
        'barang_id' => $request->barang_id,
        'jumlah' => $request->jumlah,
        'tanggal_pinjam' => $request->tanggal_pinjam,
        'tanggal_kembali' => $request->tanggal_kembali,
        'status' => $request->status,
        'foto' => $fotoPath,
    ]);


        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $userId = Auth::id();
        $pinjam = Peminjaman::where('id', $id)->where('user_id', $userId)->firstOrFail();

        if ($pinjam->foto && Storage::disk('public')->exists($pinjam->foto)) {
            Storage::disk('public')->delete($pinjam->foto);
        }

        $pinjam->delete();

        return redirect()->route('petugas.peminjaman.index')
            ->with('success', 'Data peminjaman berhasil dihapus.');
    }

    public function exportExcel()
    {
        return Excel::download(new PeminjamanExport, 'data_peminjaman.xlsx');
    }

    public function formPengembalian()
    {
        $userId = Auth::id();
        $peminjaman = Peminjaman::with('barang')
            ->where('user_id', $userId)
            ->where('status', 'Dipinjam')
            ->get();

        return view('petugas.peminjaman.pengembalian', compact('peminjaman'));
    }

    public function prosesPengembalian(Request $request, $id)
    {
        $userId = Auth::id();

        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_barang' => 'required|string|max:255',
        ]);

        $pinjam = Peminjaman::with('barang')
            ->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $barang = $pinjam->barang;
        $barang->stok += $pinjam->jumlah;
        $barang->save();

        $pinjam->update([
            'tanggal_kembali' => $request->tanggal_kembali,
            'kondisi_barang' => $request->kondisi_barang,
            'status' => 'Dikembalikan',
        ]);

        return redirect()->route('petugas.pengembalian.form')
            ->with('success', 'Barang berhasil dikembalikan dan stok diperbarui.');
    }
}
