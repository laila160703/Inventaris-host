@extends('layouts.admin')

@section('title', 'Verifikasi Pengembalian')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white dark:bg-gray-800 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-6 text-gray-800 dark:text-white">✅ Verifikasi Pengembalian Barang</h2>

   <form action="{{ route('admin.peminjaman.verifikasi.submit', $peminjaman->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Nama Peminjam:</label>
            <p>{{ $peminjaman->user->name }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-semibold text-gray-700 dark:text-gray-200">Barang:</label>
            <p>{{ $peminjaman->barang->nama_barang }}</p>
        </div>

        <div class="mb-4">
            <label for="tanggal_kembali" class="block font-semibold text-gray-700 dark:text-gray-200">Tanggal Kembali:</label>
            <input type="date" id="tanggal_kembali" name="tanggal_kembali" required
                class="w-full border px-3 py-2 rounded-lg dark:bg-gray-900 dark:text-white @error('tanggal_kembali') border-red-500 @enderror">
            @error('tanggal_kembali')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="kondisi_barang" class="block font-semibold text-gray-700 dark:text-gray-200">Kondisi Barang:</label>
            <select name="kondisi_barang" id="kondisi_barang" required
                class="w-full border px-3 py-2 rounded-lg dark:bg-gray-900 dark:text-white">
                <option value="">-- Pilih Kondisi --</option>
                <option value="baik">Baik</option>
                <option value="rusak">Rusak</option>
            </select>
            @error('kondisi_barang')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded shadow">Simpan Verifikasi</button>
        <a href="{{ route('admin.peminjaman.index') }}"
            class="ml-2 text-gray-700 dark:text-gray-300 hover:underline">Batal</a>
    </form>
</div>
@endsection
