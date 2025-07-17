<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\AduanBarang;


class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('admin.dashboard', compact('user'));
    }

    public function prosesAduan()
    {
        $aduans = AduanBarang::with('barang')->orderBy('created_at', 'desc')->get();
        return view('admin.aduan.proses', compact('aduans'));
    }

    public function updateStatus(AduanBarang $aduan, $status)
    {
        $aduan->update(['status' => $status]);
        return redirect()->back()->with('success', 'Status aduan berhasil diperbarui.');
    }
}
