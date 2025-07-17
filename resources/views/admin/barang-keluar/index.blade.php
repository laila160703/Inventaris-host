@extends('layouts.admin')

@section('title', 'Data Barang Keluar')

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white leading-tight mb-4">
        Data Barang Keluar
    </h2>

    @if (session('success'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white dark:bg-gray-800 p-4 rounded-md shadow border border-gray-200 dark:border-gray-700">
        <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
            <a href="{{ route('admin.barang-keluar.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                ➖ Tambah Barang Keluar
            </a>

            <form action="{{ route('admin.barang-keluar.index') }}" method="GET" class="flex flex-wrap gap-2 items-center">
                <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}"
                    class="text-sm border rounded px-3 py-1" />
                <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                    class="text-sm border rounded px-3 py-1" />
                <button type="submit" class="bg-green-600 text-white px-3 py-1 rounded text-sm">🗂️ Filter</button>
                @if(request()->has('search') || request()->has('tanggal'))
                    <a href="{{ route('admin.barang-keluar.index') }}" class="text-blue-600 text-sm hover:underline">🔄 Reset</a>
                @endif
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-sm border border-gray-300">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Kode Transaksi</th>
                        <th class="px-4 py-2 border">Barang</th>
                        <th class="px-4 py-2 border">Tanggal Keluar</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Satuan</th>
                        <th class="px-4 py-2 border">Penerima</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                        <th class="px-4 py-2 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900">
                    @forelse ($barangKeluars as $index => $item)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 border text-center">{{ $barangKeluars->firstItem() + $index }}</td>
                            <td class="px-4 py-2 border font-mono text-blue-700">{{ $item->kode_transaksi }}</td>
                            <td class="px-4 py-2 border">{{ $item->barang->nama_barang }}</td>
                            <td class="px-4 py-2 border">{{ $item->tanggal_keluar }}</td>
                            <td class="px-4 py-2 border">{{ $item->jumlah }}</td>
                            <td class="px-4 py-2 border">{{ $item->barang->satuan }}</td>
                           <td class="px-4 py-2 border">{{ $item->bidang->nama ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $item->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2 border text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.barang-keluar.edit', $item->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-xs">✏️</a>
                                    <form action="{{ route('admin.barang-keluar.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">🗑️</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-4 py-2 text-center border text-gray-500">Tidak ada data.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $barangKeluars->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection
