@extends('layouts.admin')

@section('title', 'Edit Peminjaman')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-6">Edit Peminjaman</h2>

    <form action="{{ route('peminjaman.update', $peminjaman) }}" method="POST" class="space-y-4 max-w-lg bg-white dark:bg-gray-800 p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label for="nama_peminjam" class="block text-gray-700 dark:text-white font-semibold mb-1">Nama Peminjam</label>
            <input type="text" name="nama_peminjam" id="nama_peminjam"
                   value="{{ old('nama_peminjam', $peminjaman->nama_peminjam) }}"
                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label for="barang_id" class="block text-gray-700 dark:text-white font-semibold mb-1">Nama Barang</label>
            <select name="barang_id" id="barang_id" class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
                <option value="">-- Pilih Barang --</option>
                @foreach ($barangs as $barang)
                    <option value="{{ $barang->id }}" {{ $barang->id == old('barang_id', $peminjaman->barang_id) ? 'selected' : '' }}>
                        {{ $barang->nama_barang }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="jumlah" class="block text-gray-700 dark:text-white font-semibold mb-1">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah"
                   value="{{ old('jumlah', $peminjaman->jumlah) }}"
                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label for="tanggal_pinjam" class="block text-gray-700 dark:text-white font-semibold mb-1">Tanggal Pinjam</label>
            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                   value="{{ old('tanggal_pinjam', $peminjaman->tanggal_pinjam) }}"
                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white" required>
        </div>

        <div>
            <label for="tanggal_kembali" class="block text-gray-700 dark:text-white font-semibold mb-1">Tanggal Kembali</label>
            <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                   value="{{ old('tanggal_kembali', $peminjaman->tanggal_kembali) }}"
                   class="w-full p-2 border rounded dark:bg-gray-700 dark:text-white">
        </div>

        <div class="flex space-x-2">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                Update
            </button>
            <a href="{{ route('peminjaman.index') }}" class="text-gray-700 dark:text-gray-300 hover:underline">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
