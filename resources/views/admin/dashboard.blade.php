@extends('layouts.admin')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">📊 Dashboard Admin</h2>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <x-dashboard-card icon="users" bg="blue" label="Total Pengguna" :value="$totalUsers" />
        <x-dashboard-card icon="folder-open" bg="green" label="Total Peminjaman" :value="$totalPeminjaman" />
        <x-dashboard-card icon="exclamation-triangle" bg="red" label="Total Aduan Barang" :value="$totalAduan" />
        <x-dashboard-card icon="boxes" bg="purple" label="Total Barang" :value="$totalBarang ?? 0" />

    </div>

    {{-- Progress Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">📦 Status Peminjaman</h3>
            <div class="space-y-4">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Dipinjam ({{ $countDipinjam }} barang)</p>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-yellow-500 h-3 rounded-full" style="width: {{ $percentDipinjam }}%"></div>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Dikembalikan ({{ $countKembali }} barang)</p>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-green-500 h-3 rounded-full" style="width: {{ $percentKembali }}%"></div>
                    </div>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-1">Ditolak ({{ $countDitolak }} barang)</p>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-red-500 h-3 rounded-full" style="width: {{ $percentDitolak }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Panel Aktivitas Terbaru --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">🕓 Aktivitas Terbaru</h3>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($latestPeminjaman as $pinjam)
                    <li class="py-2">
                        <p class="text-sm text-gray-800 dark:text-gray-100">
                            <strong>{{ $pinjam->user->name ?? '-' }}</strong> mengajukan pinjam
                            <strong>{{ $pinjam->barang->nama_barang ?? '-' }}</strong>
                            <span class="text-xs text-gray-500 ml-2">({{ $pinjam->created_at->diffForHumans() }})</span>
                        </p>
                    </li>
                @empty
                    <li class="py-2 text-gray-500 dark:text-gray-300 text-sm">Tidak ada aktivitas baru.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- Informasi Sistem --}}
    <div class="bg-yellow-100 dark:bg-yellow-600 text-yellow-900 dark:text-white p-6 rounded-lg shadow leading-relaxed">
        <h3 class="text-xl font-semibold mb-3">📌 Tentang Sistem </h3>
        <p class="mb-2">
            <strong>Inventaris</strong> (Sistem Barang Diskominfo Barito Kuala) adalah sistem digital yang digunakan untuk mengelola aset, barang inventaris, serta aduan dan peminjaman barang oleh petugas.
        </p>
        <ul class="list-disc pl-6 space-y-1 text-sm">
            <li>Mempermudah manajemen barang antar bidang dan admin Utama.</li>
            <li>Memberikan transparansi dan efisiensi dalam pengelolaan aset daerah.</li>
            <li>Mempermudah petugas mengajukan pinjam dan menyampaikan aduan barang.</li>
            <li>Admin dapat memantau aktivitas dan memproses ajuan peminjaman.</li>
        </ul>
    </div>
</div>
@endsection
