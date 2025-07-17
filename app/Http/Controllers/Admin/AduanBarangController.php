<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\AduanBarang;
use App\Models\Barang;

class AduanBarangController extends Controller
{
    

    public function index(Request $request)
    {
        $search = $request->input('search');

        $aduans = AduanBarang::with(['barang', 'user']) 
            ->when($search, function ($query, $search) {
                $query->where('nama_pengadu', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('telepon', 'like', "%{$search}%")
                    ->orWhereHas('barang', function ($q) use ($search) {
                        $q->where('nama_barang', 'like', "%{$search}%");
                    })
                    ->orWhere('jenis_aduan', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%");
            })
            ->orderBy('tanggal_aduan', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.aduan.index', compact('aduans'));
    }

    public function create()
    {
        $barangs = Barang::all();
        return view('admin.aduan.create', compact('barangs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'barang_id'      => 'required|exists:barangs,id',
            'email'          => 'required|email',
            'telepon'        => 'required|string|max:20',
            'jenis_aduan'    => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'tanggal_aduan'  => 'required|date',
            'foto'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'barang_id.required'     => 'Kolom nama barang wajib diisi.',
            'barang_id.exists'       => 'Barang tidak ditemukan.',
            'email.required'         => 'Kolom email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'telepon.required'       => 'Kolom telepon wajib diisi.',
            'jenis_aduan.required'   => 'Jenis aduan wajib dipilih.',
            'tanggal_aduan.required' => 'Tanggal aduan wajib diisi.',
            'foto.required'          => 'Foto barang wajib diunggah.',
            'foto.image'             => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

          $validated['nama_pengadu'] = Auth::user()->name;
         $validated['user_id'] = Auth::id(); // Tambahkan ini

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('aduan_fotos', 'public');
        }

        AduanBarang::create($validated);

        return redirect()->route('admin.aduan.index')->with('success', 'Aduan berhasil disimpan.');
    }

    public function edit($id)
    {
        $aduan = AduanBarang::findOrFail($id);
        $barangs = Barang::all();
        return view('admin.aduan.edit', compact('aduan', 'barangs'));
    }

    public function update(Request $request, $id)
    {
        $aduan = AduanBarang::findOrFail($id);

        $validated = $request->validate([
            'barang_id'      => 'required|exists:barangs,id',
            'email'          => 'required|email',
            'telepon'        => 'required|string|max:20',
            'jenis_aduan'    => 'required|string|max:100',
            'deskripsi'      => 'nullable|string',
            'tanggal_aduan'  => 'required|date',
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'barang_id.required'     => 'Kolom nama barang wajib diisi.',
            'barang_id.exists'       => 'Barang tidak ditemukan.',
            'email.required'         => 'Kolom email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'telepon.required'       => 'Kolom telepon wajib diisi.',
            'jenis_aduan.required'   => 'Jenis aduan wajib dipilih.',
            'tanggal_aduan.required' => 'Tanggal aduan wajib diisi.',
            'foto.image'             => 'File yang diunggah harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max'               => 'Ukuran foto maksimal 2MB.',
        ]);

        if ($request->hasFile('foto')) {
            if ($aduan->foto && Storage::disk('public')->exists($aduan->foto)) {
                Storage::disk('public')->delete($aduan->foto);
            }

            $validated['foto'] = $request->file('foto')->store('aduan_fotos', 'public');
        }

        $aduan->update($validated);

        return redirect()->route('admin.aduan.index')->with('success', 'Aduan berhasil diperbarui.');
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $aduan = AduanBarang::findOrFail($id);
        $aduan->status = $request->status;
        $aduan->save();

        return redirect()->route('admin.aduan.index')->with('success', 'Status aduan berhasil diperbarui.');
    }


}
