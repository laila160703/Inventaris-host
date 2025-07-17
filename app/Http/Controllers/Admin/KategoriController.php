<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategories = Kategori::all();
        return view('admin.kategori.index', compact('kategories'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',  // Validasi kolom 'nama'
    ]);

    Kategori::create([
        'nama' => $request->nama,  // Menyimpan data ke kolom 'nama'
    ]);

    return redirect()->route('admin.kategori.index');
}


    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
{
    $request->validate([
        'nama' => 'required|string|max:255',  // Validasi kolom 'nama'
    ]);

    // Mengupdate data kolom 'nama'
    $kategori->update([
        'nama' => $request->nama,  // Mengupdate data ke kolom 'nama'
    ]);

    return redirect()->route('admin.kategori.index');
}

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();
        return redirect()->route('admin.kategori.index');
    }
}
