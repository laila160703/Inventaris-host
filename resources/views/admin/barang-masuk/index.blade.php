@extends('layouts.admin')

@section('title', 'Data Barang Masuk')

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- Header --}}
    <h2 class="text-2xl font-semibold text-gray-700 dark:text-white leading-tight mb-4">
        📥 Data Barang Masuk
    </h2>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 border border-green-300 rounded shadow-sm">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Panel Atas --}}
    <div class="bg-white dark:bg-gray-800 p-4 rounded-md shadow border border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap gap-3 items-center justify-between mb-4">
            {{-- Tombol Tambah --}}
            <a href="{{ route('admin.barang-masuk.create') }}"
               class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 text-sm rounded shadow flex items-center gap-2">
                ➕ Tambah Barang Masuk
            </a>

            {{-- Filter Form --}}
            <form action="{{ route('admin.barang-masuk.index') }}" method="GET" class="flex flex-wrap items-center gap-2">
                {{-- Pencarian --}}
                <div class="flex items-center border border-gray-300 rounded px-3 py-1 bg-gray-50 text-sm w-52">
                    🔍
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari barang..." class="w-full focus:outline-none bg-transparent ml-2" />
                </div>

                {{-- Tanggal --}}
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                       class="border border-gray-300 rounded px-3 py-1 text-sm bg-gray-50" />

                {{-- Tombol Filter --}}
                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-sm rounded shadow flex items-center gap-1">
                    🗂️ Filter
                </button>

                {{-- Reset --}}
                @if(request()->has('search') || request()->has('tanggal'))
                    <a href="{{ route('admin.barang-masuk.index') }}"
                       class="text-sm text-blue-600 hover:underline ml-2">
                        🔄 Reset
                    </a>
                @endif
            </form>
        </div>

        {{-- Tabel --}}
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-300 border-collapse">
                <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Kode Transaksi</th>
                        <th class="px-4 py-2 border">Barang</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Satuan</th>
                        <th class="px-4 py-2 border">Supplier</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900">
                    @forelse ($barangMasuks as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-2 border text-center">{{ $barangMasuks->firstItem() + $index }}</td>
                        <td class="px-4 py-2 border text-blue-700 font-mono">{{ $item->kode_transaksi }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->nama_barang }}</td>
                        <td class="px-4 py-2 border">{{ $item->tanggal_masuk }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->jumlah }}</td>
                        <td class="px-4 py-2 border text-center">{{ $item->barang->satuan }}</td>
                        <td class="px-4 py-2 border">{{ $item->supplier }}</td>
                        <td class="px-4 py-2 border">{{ $item->keterangan ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">
                            <div class="flex justify-center gap-2">
                                <a href="{{ route('admin.barang-masuk.edit', $item->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-xs shadow">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('admin.barang-masuk.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs shadow">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center px-4 py-3 border text-gray-500">😔 Tidak ada data ditemukan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-4">
            {{ $barangMasuks->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
