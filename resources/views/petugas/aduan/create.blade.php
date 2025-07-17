@extends('layouts.petugas')

@section('title', 'Tambah Aduan Barang')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📝 Buat Aduan Barang</h1>

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-6">
        @if($errors->any())
            <div class="mb-4 px-4 py-2 bg-red-100 border border-red-300 text-red-700 rounded">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.aduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="barang_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Nama Barang</label>
                    <select name="barang_id" id="barang_id" class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:outline-none">
                        <option value="">-- Pilih Barang --</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                                {{ $barang->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" min="1"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:outline-none"
                        value="{{ old('jumlah') }}">
                </div>

                <div>
                    <label for="jenis_aduan" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Jenis Aduan</label>
                    <input type="text" name="jenis_aduan" id="jenis_aduan"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:outline-none"
                        placeholder="Contoh: Rusak, Hilang" value="{{ old('jenis_aduan') }}">
                </div>

                <div>
                    <label for="tanggal_aduan" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Tanggal Aduan</label>
                    <input type="date" name="tanggal_aduan" id="tanggal_aduan"
                        class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:outline-none"
                        value="{{ old('tanggal_aduan', \Carbon\Carbon::now()->toDateString()) }}">
                </div>
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4"
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded focus:ring-blue-500 focus:outline-none"
                    placeholder="Jelaskan kondisi barang...">{{ old('deskripsi') }}</textarea>
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-sm font-semibold text-gray-700 dark:text-gray-200">Foto Barang (opsional)</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                    class="w-full mt-1 px-3 py-2 border border-gray-300 rounded file:mr-4 file:py-2 file:px-4 file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex justify-end">
                <a href="{{ route('petugas.aduan.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded mr-2">Kembali</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow">
                    Kirim Aduan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
