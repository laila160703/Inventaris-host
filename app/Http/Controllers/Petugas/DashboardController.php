<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjaman;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard petugas.
     */
   public function index()
{
    $userId = Auth::id();

    // Hitung data statistik
    $totalPeminjaman = Peminjaman::where('user_id', $userId)->count();
    $dipinjam = Peminjaman::where('user_id', $userId)->where('status', 'Dipinjam')->count();
    $dikembalikan = Peminjaman::where('user_id', $userId)->where('status', 'Dikembalikan')->count();

    // Ambil 5 aktivitas terbaru dari tabel peminjaman
    $aktivitas = Peminjaman::where('user_id', $userId)
        ->orderBy('created_at', 'desc')
        ->take(5)
        ->get()
        ->map(function ($item) {
            return (object)[
                'deskripsi' => "Peminjaman #{$item->kode_peminjaman} - {$item->status}",
                'created_at' => $item->created_at
            ];
        });

    return view('petugas.dashboard', compact(
        'totalPeminjaman',
        'dipinjam',
        'dikembalikan',
        'aktivitas'
    ));
}

}
