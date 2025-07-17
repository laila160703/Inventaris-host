@extends('layouts.petugas')

@section('title', 'Form Pengembalian Barang')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">📦 Form Pengembalian Barang</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @forelse ($peminjaman as $pinjam)
        <div class="bg-white dark:bg-gray-800 rounded shadow p-4 mb-6">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-white mb-2">Barang: {{ $pinjam->barang->nama_barang }}</h2>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Jumlah: {{ $pinjam->jumlah }}</p>

            @if ($pinjam->foto)
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Foto Bukti Peminjaman Barang</label>
                    <img src="{{ asset('storage/' . $pinjam->foto) }}" alt="Foto Bukti" class="h-32 rounded shadow">
                </div>
            @else
                <p class="text-sm italic text-gray-400">Tidak ada foto peminjaman.</p>
            @endif

            <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">Tanggal Pinjam: {{ $pinjam->tanggal_pinjam }}</p>

            <form action="{{ route('petugas.pengembalian.proses', $pinjam->id) }}" method="POST">
                @csrf

                <div>
                    <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" class="mt-1 block w-full border px-4 py-2 rounded dark:bg-gray-900 dark:text-white" required>
                </div>

                <div>
                    <label for="kondisi_barang" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Kondisi Barang</label>
                    <textarea name="kondisi_barang" rows="3" class="mt-1 block w-full border px-4 py-2 rounded dark:bg-gray-900 dark:text-white" placeholder="Contoh: Baik, rusak ringan..." required></textarea>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Kembalikan Barang
                </button>
            </form>
        </div>
    @empty
        <div class="text-gray-600 dark:text-gray-300">Tidak ada peminjaman yang perlu dikembalikan.</div>
    @endforelse
</div>
@endsection
