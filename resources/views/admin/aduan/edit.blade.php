@extends('layouts.admin')

@section('title', 'Edit Aduan Barang')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">✏️ Edit Aduan Barang</h1>

    <div class="max-w-4xl bg-white dark:bg-gray-800 p-6 rounded shadow-lg mx-auto">
        <form action="{{ route('admin.aduan.update', $aduan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="barang_id" class="block font-medium text-gray-700 dark:text-gray-200">Nama Barang</label>
                <select name="barang_id" class="w-full border px-4 py-2 rounded @error('barang_id') border-red-500 @enderror">
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id', $aduan->barang_id) == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Nama Pengadu</label>
                <input type="text" name="nama_pengadu" class="w-full border px-4 py-2 rounded bg-gray-100"
                    value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Email</label>
                <input type="email" name="email"
                    class="w-full border px-4 py-2 rounded @error('email') border-red-500 @enderror"
                    value="{{ old('email', $aduan->email) }}">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Telepon</label>
                <input type="text" name="telepon"
                    class="w-full border px-4 py-2 rounded @error('telepon') border-red-500 @enderror"
                    value="{{ old('telepon', $aduan->telepon) }}">
                @error('telepon')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Jenis Aduan</label>
                <select name="jenis_aduan"
                    class="w-full border px-4 py-2 rounded @error('jenis_aduan') border-red-500 @enderror">
                    <option value="">-- Pilih Jenis Aduan --</option>
                    <option value="Rusak" {{ old('jenis_aduan', $aduan->jenis_aduan) == 'Rusak' ? 'selected' : '' }}>Rusak</option>
                    <option value="Hilang" {{ old('jenis_aduan', $aduan->jenis_aduan) == 'Hilang' ? 'selected' : '' }}>Hilang</option>
                    <option value="Tidak Berfungsi" {{ old('jenis_aduan', $aduan->jenis_aduan) == 'Tidak Berfungsi' ? 'selected' : '' }}>Tidak Berfungsi</option>
                    <option value="Lainnya" {{ old('jenis_aduan', $aduan->jenis_aduan) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
                @error('jenis_aduan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Deskripsi</label>
                <textarea name="deskripsi"
                    class="w-full border px-4 py-2 rounded @error('deskripsi') border-red-500 @enderror"
                    rows="3">{{ old('deskripsi', $aduan->deskripsi) }}</textarea>
                @error('deskripsi')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Tanggal Aduan</label>
                <input type="date" name="tanggal_aduan"
                    class="w-full border px-4 py-2 rounded @error('tanggal_aduan') border-red-500 @enderror"
                    value="{{ old('tanggal_aduan', $aduan->tanggal_aduan) }}">
                @error('tanggal_aduan')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium text-gray-700 dark:text-gray-200">Foto Barang</label>
                <input type="file" name="foto"
                    class="w-full border px-4 py-2 rounded @error('foto') border-red-500 @enderror">
                @error('foto')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
                @if ($aduan->foto)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Barang" class="w-32 rounded border">
                    </div>
                @endif
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Update Aduan
                </button>
                <a href="{{ route('admin.aduan.index') }}" class="ml-2 bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
