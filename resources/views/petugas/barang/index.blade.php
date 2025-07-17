@extends('layouts.petugas')

@section('title', 'Barang Bidang Saya')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-white via-blue-100 to-indigo-100 ...">

            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-extrabold text-gray-800 dark:text-white flex items-center space-x-2">
                    <span>📦</span>
                    <span>Barang Bidang Saya</span>
                </h2>
                <form method="GET" action="{{ route('petugas.barang.index') }}" class="flex">
                    <input type="text" name="search" placeholder="Cari barang..."
                           value="{{ request('search') }}"
                           class="px-4 py-2 rounded-l-full border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:outline-none">
                    <button class="px-4 py-2 bg-blue-600 text-white rounded-r-full hover:bg-blue-700 transition">
                        Cari
                    </button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-2xl shadow ring-1 ring-gray-200 dark:ring-gray-700">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-sm text-gray-700 dark:text-white">
                    <thead class="bg-blue-100 dark:bg-blue-900 text-left text-xs font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Merk/Type</th>
                            <th class="px-4 py-3 text-center">Jumlah Barang</th>
                            <th class="px-4 py-3 text-center">Stok Utama</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-100 dark:divide-gray-700">
                        @forelse ($barangs as $index => $item)
                        <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                            <td class="px-4 py-3">{{ $barangs->firstItem() + $index }}</td>
                            <td class="px-4 py-3">{{ $item->barang->kode_barang ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->barang->nama_barang ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->barang->merk_type ?? '-' }}</td>
                            <td class="px-4 py-3 text-center">{{ $item->jumlah }}</td> {{-- Ini dari barang_bidangs --}}
                            <td class="px-4 py-3 text-center">{{ $item->barang->stok ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->barang->satuan ?? '-' }}</td>
                            <td class="px-4 py-3">{{ $item->barang->kategori->nama ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-6 text-gray-500">Tidak ada barang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex justify-end">
                {{ $barangs->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
