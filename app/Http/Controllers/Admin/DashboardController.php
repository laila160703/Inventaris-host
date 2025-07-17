<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Peminjaman;
use App\Models\AduanBarang;
use App\Models\Barang;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalPeminjaman = Peminjaman::count();
        $totalAduan = AduanBarang::count();
        $totalBarang = Barang::count();

        $countDipinjam = Peminjaman::where('status', 'Dipinjam')->count();
        $countKembali = Peminjaman::where('status', 'Dikembalikan')->count();
        $countDitolak = Peminjaman::where('status', 'Ditolak')->count();

        $totalStatus = max($countDipinjam + $countKembali + $countDitolak, 1);
        $percentDipinjam = ($countDipinjam / $totalStatus) * 100;
        $percentKembali = ($countKembali / $totalStatus) * 100;
        $percentDitolak = ($countDitolak / $totalStatus) * 100;

        $latestPeminjaman = Peminjaman::with('user', 'barang')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalPeminjaman',
            'totalAduan',
            'totalBarang',
            'countDipinjam',
            'countKembali',
            'countDitolak',
            'percentDipinjam',
            'percentKembali',
            'percentDitolak',
            'latestPeminjaman'
        ));
    }
}
