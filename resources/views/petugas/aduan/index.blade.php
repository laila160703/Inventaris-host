@extends('layouts.petugas')

@section('title', 'Daftar Aduan Saya')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📋 Daftar Aduan Saya</h1>

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6 overflow-x-auto">

        @if(session('success'))
            <div class="mb-4 px-4 py-2 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('petugas.aduan.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow text-sm">
                + Tambah Aduan
            </a>

            <form method="GET" action="{{ route('petugas.aduan.index') }}" class="flex space-x-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aduan..."
            class="px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:outline-none" />
        
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-2 rounded flex items-center justify-center"
            title="Cari">
            🔍
        </button>

        @if(request('search'))
            <a href="{{ route('petugas.aduan.index') }}"
            class="bg-gray-300 hover:bg-gray-400 text-black px-3 py-2 rounded text-sm">
                🔄 Reset
            </a>
        @endif
    </form>

        </div>

        <table class="min-w-full table-auto border border-gray-300 text-sm text-gray-800 dark:text-gray-100">
            <thead class="bg-blue-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2">No</th>
                    <th class="px-4 py-2">Barang</th>
                    <th class="px-4 py-2">Jenis Aduan</th>
                    <th class="px-4 py-2">Deskripsi</th>
                    <th class="px-4 py-2">Tanggal Aduan</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Foto</th>
                    <th class="px-4 py-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($aduans as $aduan)
                    <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} border-t">
                        <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $aduan->barang->nama_barang ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $aduan->jenis_aduan }}</td>
                        <td class="px-4 py-2">{{ $aduan->deskripsi }}</td>
                        <td class="px-4 py-2">{{ \Carbon\Carbon::parse($aduan->tanggal_aduan)->format('d-m-Y') }}</td>
                        <td class="px-4 py-2">
                            <span class="px-2 py-1 rounded text-xs
                                @if($aduan->status == 'diterima') bg-green-100 text-green-800
                                @elseif($aduan->status == 'ditolak') bg-red-100 text-red-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($aduan->status ?? 'menunggu') }}
                            </span>
                        </td>
                        <td class="px-4 py-2 text-center">
                            @if ($aduan->foto)
                                <a href="{{ asset('storage/' . $aduan->foto) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Aduan"
                                         class="w-12 h-12 object-cover rounded mx-auto">
                                </a>
                            @else
                                <span class="text-gray-500 italic">Tidak ada foto</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('petugas.aduan.edit', $aduan->id) }}"
                                class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow text-xs">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('petugas.aduan.destroy', $aduan->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus aduan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded shadow text-xs">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-300">
                            Belum ada aduan barang.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
