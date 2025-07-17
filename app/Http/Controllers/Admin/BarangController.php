<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BarangImport;
use Milon\Barcode\Facades\DNS2DFacade as DNS2D;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('showPublic');
    }

    public function index(Request $request)
    {
        $query = Barang::query();
        $user = Auth::user();

        if ($user->role === 'petugas' && $user->bidang_id) {
            $query->whereHas('bidangs', function ($q) use ($user) {
                $q->where('bidangs.id', $user->bidang_id);
            });
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
            });
        }

        $barangs = $query->with(['kategori', 'bidangs'])->paginate($request->get('perPage', 10));
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        $namaBarangs = Barang::select('nama_barang')->distinct()->get();
        $bidangs = Bidang::all();

        return view('admin.barang.create', compact('kategoris', 'namaBarangs', 'bidangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'nullable|string|max:100',
            'kategori_id' => 'required|exists:kategoris,id',
            'merk_type' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'sumber_barang' => 'required|string|max:50',
            'harga_barang' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'bidang_id' => 'required|exists:bidangs,id',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $validated['kode_barang'] = $this->generateKodeBarangAngka();
        $validated['stok'] = $validated['jumlah'];

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gambar', $namaFile, 'public');
            $validated['gambar'] = 'gambar/' . $namaFile;
        }

        $barang = Barang::create($validated);
        $barang->bidangs()->attach($request->bidang_id); // satu bidang

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $barang = Barang::with('bidangs')->findOrFail($id);
        $kategoris = Kategori::all();
        $bidangs = Bidang::all();

        return view('admin.barang.edit', compact('barang', 'kategoris', 'bidangs'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kode_barang' => 'required|string|max:100|unique:barangs,kode_barang,' . $barang->id,
            'kategori_id' => 'required|exists:kategoris,id',
            'merk_type' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'sumber_barang' => 'required|string|max:50',
            'harga_barang' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'bidang_id' => 'required|exists:bidangs,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('gambar', $namaFile, 'public');
            $validated['gambar'] = 'gambar/' . $namaFile;
        }

        $barang->update(array_merge($validated, ['stok' => $validated['jumlah']]));

        $barang->bidangs()->sync([$request->bidang_id]); // hanya 1 bidang

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);

        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->bidangs()->detach();
        $barang->delete();

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    public function show($id)
    {
        $barang = Barang::with('kategori', 'bidangs')->findOrFail($id);
        return view('admin.barang.show', compact('barang'));
    }

    public function showPublic($id)
    {
        $barang = Barang::with('kategori')->findOrFail($id);
        return view('admin.barang.public', compact('barang'));
    }

    public function cetakQR($id)
    {
        $barang = Barang::with('kategori', 'bidangs')->findOrFail($id);
        $qrCode = DNS2D::getBarcodeHTML(route('barang.public', $barang->id), 'QRCODE', 5, 5);

        $pdf = Pdf::loadView('admin.barang.qr-pdf', compact('barang', 'qrCode'))
                  ->setPaper('a6', 'portrait');

        return $pdf->download('QR-' . $barang->kode_barang . '.pdf');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file_excel' => 'required|mimes:xlsx,csv,xls',
        ]);

        try {
            Excel::import(new BarangImport, $request->file('file_excel'));
            return back()->with('success', 'Data barang berhasil diimpor!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal impor: ' . $e->getMessage());
        }
    }

    public function downloadPDF(Request $request)
    {
        $query = Barang::with('kategori', 'bidangs');

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        $barangs = $query->get();

        $pdf = Pdf::loadView('admin.barang.pdf', compact('barangs'))->setPaper('a4', 'landscape');
        return $pdf->download('buku-inventaris-gabungan.pdf');
    }

    public function getKodeBarang($nama)
    {
        $prefix = '01.01.01.05.';

        $lastKode = Barang::where('nama_barang', $nama)
            ->where('kode_barang', 'like', $prefix . '%')
            ->orderByDesc('kode_barang')
            ->value('kode_barang');

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return response()->json([
            'kode_barang' => $prefix . $newNumber
        ]);
    }

    private function generateKodeBarangAngka()
    {
        $prefix = '01.01.01.05.';

        $lastKode = Barang::where('kode_barang', 'like', $prefix . '%')
            ->orderByDesc('kode_barang')
            ->value('kode_barang');

        if ($lastKode) {
            $lastNumber = (int) substr($lastKode, strlen($prefix));
            $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '001';
        }

        return $prefix . $newNumber;
    }

    public function simplePDF()
    {
        $pdf = Pdf::loadHTML('<h1>Hello, World!</h1>');
        return $pdf->download('simple.pdf');
    }
}
