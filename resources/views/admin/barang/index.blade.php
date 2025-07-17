@extends('layouts.admin')

@section('title', 'Data Barang')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-xl rounded-xl p-6">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">📦 Data Barang</h2>
                <a href="{{ route('admin.barang.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                    ➕ Tambah Barang
                </a>
            </div>

            {{-- Notifikasi --}}
           

            {{-- Form Import & Search --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
                <form method="GET" action="{{ route('admin.barang.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari barang..." class="px-4 py-2 border rounded shadow-sm" />
                    <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded hover:bg-blue-700">
                        🔍 Cari
                    </button>
                </form>
               <div class="flex gap-2">
                <a href="{{ route('admin.barang.export.pdf') }}" target="_blank"
                class="bg-gray-600 hover:bg-red-700 text-white px-3 py-2 rounded-md shadow inline-flex items-center gap-2">
                    🧾 PDF
                </a>
            </div>


            </div>

            {{-- Per Page --}}
            <form method="GET" action="{{ route('admin.barang.index') }}" class="mb-4">
                <label class="text-sm text-gray-600 dark:text-gray-300">Tampilkan</label>
                <select name="perPage" onchange="this.form.submit()" class="border px-2 py-1 rounded">
                    @foreach ([10, 25, 50, 100] as $limit)
                        <option value="{{ $limit }}" {{ request('perPage') == $limit ? 'selected' : '' }}>{{ $limit }} data</option>
                    @endforeach
                </select>
            </form>

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-lg shadow">
                <table class="min-w-full text-sm text-left divide-y divide-gray-200">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-gray-700 dark:text-white uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="px-4 py-3">Kode</th>
                            <th class="px-4 py-3">Nama</th>
                            <th class="px-4 py-3">Merk/Type</th>
                            <th class="px-4 py-3">Jumlah</th>
                            <th class="px-4 py-3">Stok</th>
                            <th class="px-4 py-3">Satuan</th>
                            <th class="px-4 py-3">Harga</th>
                            <th class="px-4 py-3">Sumber</th>
                            <th class="px-4 py-3">Bidang</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Keterangan</th>
                            <th class="px-4 py-3">Gambar</th>
                            <th class="px-4 py-3">Kategori</th>
                            <th class="px-4 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($barangs as $index => $barang)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                                <td class="px-4 py-2">{{ $barangs->firstItem() + $index }}</td>
                                <td class="px-4 py-2">{{ $barang->kode_barang }}</td>
                                <td class="px-4 py-2">{{ $barang->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $barang->merk_type }}</td>
                                <td class="px-4 py-2">{{ $barang->jumlah }}</td>
                                <td class="px-4 py-2">{{ $barang->stok }}</td>
                                <td class="px-4 py-2">{{ $barang->satuan }}</td>
                                <td class="px-4 py-2">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $barang->sumber_barang }}</td>
                                <td class="px-4 py-2">
                                    {{ $barang->bidangs->first()->nama ?? '-' }}
                                </td>
                                <td class="px-4 py-2">
                                    @if($barang->stok > 0)
                                        <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Tersedia</span>
                                    @else
                                        <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Habis</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $barang->keterangan ?? '-' }}</td>
                                <td class="px-4 py-2 text-center">
                                    @if ($barang->gambar)
                                        <a href="{{ asset('storage/' . $barang->gambar) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $barang->gambar) }}" class="w-12 h-12 object-cover rounded border mx-auto">
                                        </a>
                                    @else
                                        <span class="text-gray-400 italic">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">{{ $barang->kategori->nama ?? '-' }}</td>
                                <td class="px-4 py-2">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.barang.edit', $barang->id) }}"
                                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 text-sm rounded shadow">
                                        ✏️ Edit
                                    </a>
                                    <a href="{{ route('admin.barang.show', $barang->id) }}"
                                    class="bg-slate-200 hover:bg-slate-300 text-gray-800 px-3 py-1 text-sm rounded shadow">
                                        👁️ Detail
                                    </a>
                                    <form action="{{ route('admin.barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="bg-red-100 hover:bg-red-200 text-red-800 px-3 py-1 text-sm rounded shadow">
                                            🗑️ Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="text-center px-4 py-6 text-gray-500 italic">
                                    Tidak ada data barang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6 flex justify-between items-center text-sm text-gray-600 dark:text-gray-300">
                <span>
                    Menampilkan {{ $barangs->firstItem() }} - {{ $barangs->lastItem() }} dari {{ $barangs->total() }} data
                </span>
                <div>
                    {{ $barangs->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
