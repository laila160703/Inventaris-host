<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; 
use App\Models\Bidang;
use Illuminate\Http\Request;

class BidangController extends Controller
{
   public function index(Request $request)
{
    $search = $request->input('search');

    $query = Bidang::query();

    if ($search) {
        $query->where('nama', 'like', '%' . $search . '%');
    }

    // Ambil data bidang dengan pagination
    $bidangs = $query->paginate(10);

    // Kirim data ke view
    return view('admin.bidang.index', compact('bidangs'));
}



    public function create()
    {
        return view('admin.bidang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Bidang::create($request->only('nama', 'deskripsi'));

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil ditambahkan.');
    }

    public function edit(Bidang $bidang)
    {
        return view('admin.bidang.edit', compact('bidang'));
    }

    public function update(Request $request, Bidang $bidang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $bidang->update($request->only('nama', 'deskripsi'));

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil diperbarui.');
    }

    public function destroy(Bidang $bidang)
    {
        $bidang->delete();

        return redirect()->route('admin.bidang.index')->with('success', 'Bidang berhasil dihapus.');
    }
}
