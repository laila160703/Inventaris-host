@extends('layouts.admin')

@section('title', 'Tambah Aduan Barang')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">➕ Tambah Aduan Barang</h1>

    <div class="max-w-3xl bg-white dark:bg-gray-800 p-6 rounded shadow-lg mx-auto">
        <form action="{{ route('admin.aduan.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label for="barang_id" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Barang</label>
                <select name="barang_id" id="barang_id" class="w-full border rounded px-3 py-2 @error('barang_id') border-red-500 @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="nama_pengadu" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Nama Pengadu</label>
                <input type="text" name="nama_pengadu" id="nama_pengadu"
                    class="w-full border rounded px-3 py-2 bg-gray-100"
                    value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Email</label>
                <input type="email" name="email" id="email"
                    class="w-full border rounded px-3 py-2 @error('email') border-red-500 @enderror"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="telepon" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Telepon</label>
                <input type="text" name="telepon" id="telepon"
                    class="w-full border rounded px-3 py-2 @error('telepon') border-red-500 @enderror"
                    value="{{ old('telepon') }}">
                @error('telepon')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="jenis_aduan" class="block font-semibold text-gray-700 dark:text-gray-200 mb-2">Jenis Aduan</label>
                <select name="jenis_aduan" id="jenis_aduan"
                    class="w-full border rounded px-3 py-2 @error('jenis_aduan') border-red-500 @enderror">
                    <option value="">-- Pilih Jenis Aduan --</option>
                    <option value="Rusak" {{ old('jenis_aduan') == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="Hilang" {{ old('jenis_aduan') == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    <option value="Tidak Berfungsi" {{ old('jenis_aduan') == 'Tidak Berfungsi' ? 'selected' : '' }}>Tidak Berfungsi</option>
                    <option value="Lainnya" {{ old('jenis_aduan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_aduan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Deskripsi <span class="text-sm text-gray-500">(Opsional)</span></label>
                <textarea name="deskripsi" id="deskripsi"
                    class="w-full border rounded px-3 py-2 @error('deskripsi') border-red-500 @enderror"
                    rows="3">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="tanggal_aduan" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Tanggal Aduan</label>
                <input type="date" name="tanggal_aduan" id="tanggal_aduan"
                    class="w-full border rounded px-3 py-2 @error('tanggal_aduan') border-red-500 @enderror"
                    value="{{ old('tanggal_aduan') }}">
                @error('tanggal_aduan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label for="foto" class="block text-gray-700 dark:text-gray-200 font-semibold mb-2">Foto Barang</label>
                <input type="file" name="foto" id="foto"
                    class="w-full border rounded px-3 py-2 bg-white dark:bg-gray-700 @error('foto') border-red-500 @enderror">
                @error('foto')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan Aduan
                </button>
                <a href="{{ route('admin.aduan.index') }}" class="ml-4 text-gray-600 dark:text-gray-300 hover:underline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
