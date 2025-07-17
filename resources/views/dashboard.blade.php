@extends('layouts.app')

@section('header')
<div class="flex justify-between items-center">
    <h1 class="text-2xl font-semibold text-black">SIBARAKOM</h1>
    <h2 class="font-semibold text-xl text-black leading-tight">
        {{ __('Dashboard') }}
    </h2>
</div>
@endsection

@section('content')

<!-- Welcome Message -->
<div class="overflow-hidden bg-blue-300 py-2 mb-6">
    <p class="whitespace-nowrap text-white font-bold text-xl animate-marquee">
        Selamat Datang di Dashboard SIBARAKOM
    </p>
</div>

<style>
@keyframes marquee {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
.animate-marquee {
    animation: marquee 15s linear infinite;
}
</style>

<!-- Konten Utama -->
<div class="space-y-6">

    <!-- Ringkasan Atas: Data Barang & Barang Masuk -->
    <div class="grid grid-cols-2 gap-4 w-full max-w-md">
        <!-- Data Barang -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center justify-center">
            <div class="text-purple-600 mb-2">
                <i class="fas fa-box fa-2x"></i>
            </div>
            <p class="text-sm font-semibold text-center">Data Barang</p>
            <p class="text-2xl font-bold">{{ $jumlahBarang }}</p>
        </div>

        <!-- Barang Masuk -->
        <div class="bg-white rounded-lg shadow p-4 flex flex-col items-center justify-center">
            <div class="text-green-600 mb-2">
                <i class="fas fa-arrow-down fa-2x"></i>
            </div>
            <p class="text-sm font-semibold text-center">Barang Masuk</p>
            <p class="text-2xl font-bold">{{ $jumlahBarangMasuk }}</p>
        </div>
    </div>

    <!-- Info Ringkas Lainnya -->
    <div class="grid grid-cols-3 gap-4">
    <!-- Total Barang -->
    <div class="bg-blue-100 rounded-lg shadow p-4 flex flex-col items-center justify-center">
        <svg class="h-6 w-6 text-blue-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v4a1 1 0 001 1h3v3h2v-3h3v3h2v-3h3a1 1 0 001-1V7M3 7l9-4 9 4M3 7v10a1 1 0 001 1h16a1 1 0 001-1V7" />
        </svg>
        <h2 class="text-sm font-semibold text-blue-800 text-center">Total Barang</h2>
        <p class="text-xl font-bold text-blue-800 mt-1">{{ $jumlahBarang }}</p>
    </div>

    <!-- Barang Dipinjam -->
    <div class="bg-yellow-100 rounded-lg shadow p-4 flex flex-col items-center justify-center">
        <svg class="h-6 w-6 text-yellow-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a4 4 0 00-8 0v2m-1 4h10l1 5H6l1-5z" />
        </svg>
        <h2 class="text-sm font-semibold text-yellow-800 text-center">Barang Dipinjam</h2>
        <p class="text-xl font-bold text-yellow-800 mt-1">{{ $jumlahDipinjam }}</p>
    </div>

    <!-- Total Pengguna -->
    <div class="bg-green-100 rounded-lg shadow p-4 flex flex-col items-center justify-center">
        <svg class="h-6 w-6 text-green-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87M16 7a4 4 0 11-8 0 4 4 0 018 0z" />
        </svg>
        <h2 class="text-sm font-semibold text-green-800 text-center">Total Pengguna</h2>
        <p class="text-xl font-bold text-green-800 mt-1">{{ $jumlahUser }}</p>
    </div>
</div>


    <!-- Tabel Barang Minimum -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold mb-4 flex items-center">
            <i class="fas fa-exclamation-circle text-red-500 mr-2"></i>
            Jumlah barang telah mencapai batas minimum
        </h3>
        <table class="w-full table-auto border-collapse">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">ID Barang</th>
                    <th class="border px-4 py-2">Nama Barang</th>
                    <th class="border px-4 py-2">Jenis Barang</th>
                    <th class="border px-4 py-2">Jumlah Barang</th>
                    <th class="border px-4 py-2">Satuan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($stokMinimum as $index => $barang)
                <tr>
                    <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                    <td class="border px-4 py-2 text-center">{{ $barang->kode_barang }}</td>
                    <td class="border px-4 py-2">{{ $barang->nama }}</td>
                    <td class="border px-4 py-2">{{ $barang->jenis_barang }}</td>
                    <td class="border px-4 py-2 text-center">
                        <span class="inline-block px-2 py-1 bg-red-100 text-red-600 font-semibold rounded-full">
                            {{ $barang->stok }}
                        </span>
                    </td>
                    <td class="border px-4 py-2 text-center">{{ $barang->satuan }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-gray-500 py-4">Tidak ada barang yang mencapai batas minimum.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
