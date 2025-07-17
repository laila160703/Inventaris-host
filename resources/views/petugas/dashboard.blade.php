@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="p-6">
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-6">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">📊 Dashboard Petugas</h1>
                <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                    Selamat datang, <span class="font-semibold text-blue-600">{{ auth()->user()->name }}</span> 👋
                </p>
            </div>
            <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300 text-xs font-medium px-4 py-1.5 rounded-full">
                🛡️ Petugas
            </span>
        </div>

        {{-- Statistik Kotak --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-700 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm">Total Peminjaman</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $totalPeminjaman ?? '0' }}</h2>
                    </div>
                    <div class="text-3xl">📦</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm">Belum Dikembalikan</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $dipinjam ?? '0' }}</h2>
                    </div>
                    <div class="text-3xl">⏳</div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-700 text-white p-5 rounded-xl shadow-md hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm">Sudah Dikembalikan</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $dikembalikan ?? '0' }}</h2>
                    </div>
                    <div class="text-3xl">✅</div>
                </div>
            </div>
        </div>

      {{-- Ringkasan Aktivitas --}}
<div class="mt-10">
    <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-4">📅 Aktivitas Terbaru</h3>

    @forelse($aktivitas as $log)
        <div class="flex items-start gap-4 mb-4 bg-white dark:bg-gray-700 p-4 rounded-xl shadow-md hover:shadow-lg transition-all border-l-4 border-blue-500 dark:border-blue-400">
            {{-- Icon Bulat --}}
            <div class="flex-shrink-0">
                <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-600 flex items-center justify-center text-blue-600 dark:text-white text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            {{-- Isi Aktivitas --}}
            <div class="flex-1">
                <p class="text-sm text-gray-800 dark:text-white font-medium">
                    {{ $log->deskripsi }}
                </p>
                <span class="text-xs text-gray-500 dark:text-gray-300">
                    {{ $log->created_at->diffForHumans() }}
                </span>
            </div>
        </div>
    @empty
        <div class="bg-yellow-50 dark:bg-yellow-800 text-yellow-800 dark:text-yellow-100 p-4 rounded-xl text-sm shadow text-center">
            Tidak ada aktivitas terbaru.
        </div>
    @endforelse
</div>

        {{-- Tindakan Cepat --}}
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 dark:text-white mb-3">⚡ Tindakan Cepat</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('petugas.peminjaman.create') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl shadow transition">
                    ➕ Ajukan Peminjaman
                </a>
                <a href="{{ route('petugas.aduan.create') }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-xl shadow transition">
                    🛠️ Buat Aduan
                </a>
                <a href="{{ route('petugas.barang.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-xl shadow transition">
                    🔍 Lihat Daftar Barang
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
