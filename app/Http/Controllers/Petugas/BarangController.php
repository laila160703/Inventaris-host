<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BarangBidang;

class BarangController extends Controller
{
    public function index(Request $request)
{
    $user = Auth::user();
    $bidangId = $user->bidang_id;

    // Ambil data barang yang terkait dengan bidang user login
    $query = \App\Models\BarangBidang::with(['barang.kategori'])
                ->where('bidang_id', $bidangId);

    if ($request->filled('search')) {
        $search = $request->search;
        $query->whereHas('barang', function ($q) use ($search) {
            $q->where('nama_barang', 'like', "%{$search}%")
              ->orWhere('kode_barang', 'like', "%{$search}%")
              ->orWhere('merk_type', 'like', "%{$search}%");
        });
    }

    $barangs = $query->paginate(10);

    return view('petugas.barang.index', compact('barangs'));
}


}
