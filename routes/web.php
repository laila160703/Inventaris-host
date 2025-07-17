<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AduanBarangController;
use App\Http\Controllers\Petugas\DashboardController;
use App\Http\Controllers\BarangMasukController;
use App\Http\Controllers\BarangKeluarController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Petugas\AduanBarangController as PetugasAduanBarangController;
use App\Http\Controllers\Petugas\PeminjamanController as PetugasPeminjamanController;
use App\Http\Controllers\Admin\PeminjamanController as AdminPeminjamanController;
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\BarangController as PetugasBarangController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\AduanBarangController as AdminAduanBarangController;
use App\Http\Controllers\Admin\BarangController as AdminBarangController;
use App\Http\Controllers\Admin\KategoriController as AdminKategoriController;
use App\Http\Controllers\Admin\BidangController as AdminBidangController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BarangMasukController as AdminBarangMasukController;
use App\Http\Controllers\Admin\BarangKeluarController as AdminBarangKeluarController;
use App\Http\Controllers\Admin\LaporanController as AdminLaporanController;
use App\Http\Controllers\Petugas\PetugasProfileController;
use App\Http\Controllers\Admin\AdminProfileController;









// Redirect ke login
Route::get('/', fn () => redirect('/login'));
require __DIR__ . '/auth.php';

// Public route sebelum middleware
Route::get('/public/barang/{id}', [AdminBarangController::class, 'showPublic'])->name('barang.public');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::put('/peminjaman/{id}/terima', [AdminPeminjamanController::class, 'terima'])->name('peminjaman.terima');
    Route::put('/peminjaman/{id}/tolak', [AdminPeminjamanController::class, 'tolak'])->name('peminjaman.tolak');
    Route::post('/aduan/{id}/update-status', [AdminAduanBarangController::class, 'updateStatus'])->name('aduan.update-status');
   Route::get('/barang/public/{id}', [AdminBarangController::class, 'showPublic'])->name('barang.public');
   Route::get('/barang/{id}/cetak-qr', [AdminBarangController::class, 'cetakQR'])->name('barang.cetakQR');



     Route::resource('users', AdminUserController::class);
    Route::resource('barang', AdminBarangController::class);
    Route::resource('kategori', AdminKategoriController::class);
    Route::resource('bidang', AdminBidangController::class);
   // Route::resource('users', AdminUserController::class);
    Route::resource('barang-masuk', AdminBarangMasukController::class);
    Route::resource('barang-keluar', AdminBarangKeluarController::class);
    Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.laporan');
    Route::get('/laporan/barang-masuk', [AdminLaporanController::class, 'barangMasuk'])->name('admin.barang-masuk');
    Route::get('/laporan/barang-keluar', [AdminLaporanController::class, 'barangKeluar'])->name('admin.barang-keluar');

    Route::resource('peminjaman', AdminPeminjamanController::class); 
    // routes/web.php

    

    Route::put('/peminjaman/verifikasi/{id}', [AdminPeminjamanController::class, 'verifikasiPengembalian'])
    ->name('peminjaman.verifikasi');


     Route::resource('aduan', AdminAduanBarangController::class);
     Route::put('/admin/aduan/{id}/status', [AdminAduanBarangController::class, 'updateStatus'])->name('admin.aduan.update-status');




    // Proses status peminjaman oleh admin
    

    Route::post('/barang/import', [AdminBarangController::class, 'importExcel'])->name('barang.importExcel');
   Route::get('/barang/export/pdf', [AdminBarangController::class, 'downloadPDF'])->name('barang.export.pdf');

   
  Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
  Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit'); 
  Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});



// Petugas
Route::middleware(['auth', 'petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])->name('dashboard');

    // Barang
    Route::get('/barang', [PetugasBarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{id}', [PetugasBarangController::class, 'show'])->name('barang.show');

    // Aduan
    Route::get('/aduan-barang', [PetugasAduanBarangController::class, 'index'])->name('aduan.index');
    Route::get('/aduan-barang/create', [PetugasAduanBarangController::class, 'create'])->name('aduan.create');
    Route::post('/aduan-barang', [PetugasAduanBarangController::class, 'store'])->name('aduan.store');
    Route::get('/aduan-barang/{id}/edit', [PetugasAduanBarangController::class, 'edit'])->name('aduan.edit');
    Route::put('/aduan-barang/{id}', [PetugasAduanBarangController::class, 'update'])->name('aduan.update');
    Route::delete('/aduan-barang/{id}', [PetugasAduanBarangController::class, 'destroy'])->name('aduan.destroy');


    // Peminjaman
    Route::get('/peminjaman', [PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/create', [PetugasPeminjamanController::class, 'create'])->name('peminjaman.create');
    Route::post('/peminjaman', [PetugasPeminjamanController::class, 'store'])->name('peminjaman.store');
    Route::get('/peminjaman/{id}/edit', [PetugasPeminjamanController::class, 'edit'])->name('peminjaman.edit');
    Route::put('/peminjaman/{id}', [PetugasPeminjamanController::class, 'update'])->name('peminjaman.update');
    Route::delete('/peminjaman/{id}', [PetugasPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
    Route::get('/peminjaman/export', [PetugasPeminjamanController::class, 'exportExcel'])->name('peminjaman.export');

    // Pengembalian
    Route::get('/pengembalian', [PetugasPeminjamanController::class, 'formPengembalian'])->name('pengembalian.form');
    Route::post('/pengembalian/{id}', [PetugasPeminjamanController::class, 'prosesPengembalian'])->name('pengembalian.proses');

    // ✅ Profil Petugas
     Route::get('/profile', [PetugasProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [PetugasProfileController::class, 'edit'])->name('petugas.profile.edit');
    Route::post('/profile/update', [PetugasProfileController::class, 'update'])->name('petugas.profile.update');

});


// Umum (auth)
// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//     // Barang
//     Route::post('/barang/import', [BarangController::class, 'importExcel'])->name('barang.importExcel');
//     Route::get('/barang/download-pdf', [BarangController::class, 'downloadPDF'])->name('barang.downloadPDF');
//     Route::resource('barang', BarangController::class);

//     // Kategori & Bidang
//     Route::resource('kategori', KategoriController::class);
//     Route::resource('bidang', BidangController::class);

//     // Pengguna
//     Route::resource('users', UserController::class);

//     // Peminjaman & Aduan
   
  

//     // Barang Masuk & Keluar
//     Route::resource('barang-masuk', BarangMasukController::class);
//     Route::resource('barang-keluar', BarangKeluarController::class);

//     // Laporan
//     Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.laporan');
//     Route::get('/laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.barang-masuk');
//     Route::get('/laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.barang-keluar');

//     // API bantu
//    // API: Dapatkan kode otomatis berdasarkan nama barang
Route::get('/get-kode-barang/{nama}', [AdminBarangController::class, 'getKodeBarang']);





