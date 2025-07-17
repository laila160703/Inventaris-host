@extends('layouts.petugas')

@section('title', 'Data Peminjaman')

@section('content')
<div class="container mx-auto p-4">

    {{-- 🔘 Header --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7M16 3H8a2 2 0 00-2 2v2h12V5a2 2 0 00-2-2z" />
            </svg>
            Data Peminjaman
        </h1>
    </div>

    {{-- 🔁 Tombol Pengembalian --}}
    <a href="{{ route('petugas.pengembalian.form') }}"
        class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg text-sm mb-4">
        🔁 Pengembalian Barang
    </a>

    {{-- ✅ Notifikasi --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    {{-- 🔍 Filter dan Export --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4">
        <form method="GET" action="{{ route('petugas.peminjaman.index') }}" class="flex flex-wrap gap-2 items-center">
            <select name="barang_id" class="px-3 py-2 border rounded dark:bg-gray-900 dark:border-gray-700 text-sm">
                <option value="">Semua Barang</option>
                @foreach($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ request('barang_id') == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama_barang }}
                    </option>
                @endforeach
            </select>

            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}"
                class="px-3 py-2 border rounded dark:bg-gray-900 dark:border-gray-700 text-sm" />
            <span class="text-gray-600 dark:text-gray-300">s/d</span>
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}"
                class="px-3 py-2 border rounded dark:bg-gray-900 dark:border-gray-700 text-sm" />

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">Filter</button>
            <a href="{{ route('petugas.peminjaman.index') }}" class="text-sm text-blue-600 hover:underline">Reset</a>
        </form>

        <div class="flex gap-2">
            <a href="{{ route('petugas.peminjaman.export') }}"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow text-sm">Export Excel</a>
            <a href="{{ route('petugas.peminjaman.create') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow transition text-sm">Tambah Peminjaman</a>
        </div>
    </div>

    {{-- 🔍 Pencarian --}}
    <input type="text" id="searchInput" placeholder="Cari nama barang..."
        class="w-full md:w-1/3 px-4 py-2 mb-4 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:text-white" />

    {{-- 📋 Tabel --}}
    <div class="overflow-x-auto rounded-lg">
        <table class="min-w-full table-auto border border-gray-300 dark:border-gray-600" id="dataTable">
            <thead class="bg-blue-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border text-sm font-semibold">No</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Nama Barang</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Foto</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Jumlah</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Tgl. Pinjam</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Tgl. Kembali</th>
                    <th class="px-4 py-2 border text-sm font-semibold">Status</th>
                    <th class="px-4 py-2 border text-center text-sm font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700 text-gray-800 dark:text-gray-100">
                @forelse ($peminjaman as $index => $pinjam)
                    <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                        <td class="px-4 py-2 border text-center">{{ $index + $peminjaman->firstItem() }}</td>
                        <td class="px-4 py-2 border">{{ $pinjam->barang->nama_barang ?? '-' }}</td>
                        <td class="px-4 py-2 border text-center">
                            @if ($pinjam->foto)
                                <img src="{{ asset('storage/' . $pinjam->foto) }}"
                                     alt="Foto Peminjaman" class="h-12 mx-auto rounded shadow">
                            @else
                                <span class="text-gray-400 italic">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-4 py-2 border text-center">{{ $pinjam->jumlah }}</td>
                        <td class="px-4 py-2 border">{{ $pinjam->tanggal_pinjam }}</td>
                        <td class="px-4 py-2 border">{{ $pinjam->tanggal_kembali }}</td>
                        <td class="px-4 py-2 border text-center">
                            <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-semibold 
                                {{ $pinjam->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' : ($pinjam->status == 'Dikembalikan' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800') }}">
                                {{ $pinjam->status }}
                            </span>
                        </td>
                        <td class="px-4 py-2 border text-center">
                            @if (!in_array($pinjam->status, ['Dipinjam', 'Dikembalikan']))
                                <div class="flex justify-center space-x-2">
                                    <a href="{{ route('petugas.peminjaman.edit', $pinjam->id) }}"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                        Edit
                                    </a>
                                    <form action="{{ route('petugas.peminjaman.destroy', $pinjam->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm flex items-center gap-1">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-gray-400 italic text-sm">Tidak dapat diubah</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-6 text-gray-500 dark:text-gray-300">
                            Data peminjaman belum tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-6">
        {{ $peminjaman->appends(request()->query())->links() }}
    </div>

</div>

{{-- 🔍 Script Pencarian --}}
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
