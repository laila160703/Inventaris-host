<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AduanBarang;

class AduanBarangController extends Controller
{
    /**
     * Tampilkan form tambah aduan (jika dibutuhkan)
     */
    public function create()
    {
        $barangs = \App\Models\Barang::all(); // untuk dropdown barang
        return view('petugas.aduan.create', compact('barangs'));
    }

    /**
     * Simpan aduan baru dari petugas.
     */
    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
            'jenis_aduan' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'tanggal_aduan' => 'required|date',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'barang_id', 'jumlah', 'jenis_aduan', 'deskripsi', 'tanggal_aduan'
        ]);

        $data['user_id'] = Auth::id(); // Petugas yang login
        $data['status'] = 'menunggu'; // Default status

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('aduan_foto', 'public');
        }

        AduanBarang::create($data);

        return redirect()->route('petugas.aduan.index')
            ->with('success', 'Aduan berhasil dikirim dan menunggu diproses oleh admin.');
    }

    /**
     * Tampilkan semua aduan yang dikirim oleh petugas login.
     */
   public function index(Request $request)
{
    $userId = Auth::id();

    $query = AduanBarang::with('barang')
        ->where('user_id', $userId);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->where('jenis_aduan', 'like', "%$search%")
              ->orWhere('deskripsi', 'like', "%$search%")
              ->orWhereHas('barang', function ($q2) use ($search) {
                  $q2->where('nama_barang', 'like', "%$search%");
              });
        });
    }

    $aduans = $query->orderBy('tanggal_aduan', 'desc')->paginate(10);

    return view('petugas.aduan.index', compact('aduans'));
}

}
