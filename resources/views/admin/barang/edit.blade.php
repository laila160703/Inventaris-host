@extends('layouts.admin')

@section('title', 'Edit Barang')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                ✏️ Edit Barang
            </h2>

            {{-- Error Message --}}
            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="list-disc ml-4 mt-2 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.barang.update', $barang->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Nama Barang --}}
                <div>
                    <label for="nama_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Nama Barang</label>
                    <input type="text" name="nama_barang" id="nama_barang"
                           class="w-full border rounded px-4 py-2 bg-yellow-50 border-yellow-300 focus:outline-none"
                           value="{{ old('nama_barang', $barang->nama_barang) }}" required>
                </div>

                {{-- Kode Barang (readonly) --}}
                <div>
                    <label for="kode_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang"
                           class="w-full border rounded px-4 py-2 bg-blue-100 border-blue-300 focus:outline-none text-gray-600"
                           value="{{ old('kode_barang', $barang->kode_barang) }}" readonly>
                    <p class="text-xs text-gray-400 mt-1">* Kode tidak dapat diubah.</p>
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id" class="block font-semibold text-gray-700 dark:text-white mb-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id" required
                            class="w-full border rounded px-4 py-2 bg-purple-50 border-purple-300 focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" {{ old('kategori_id', $barang->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Merk / Type --}}
                <div>
                    <label for="merk_type" class="block font-semibold text-gray-700 dark:text-white mb-1">Merk / Type</label>
                    <input type="text" name="merk_type" id="merk_type"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none"
                           value="{{ old('merk_type', $barang->merk_type) }}">
                </div>

                {{-- Jumlah dan Satuan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jumlah" class="block font-semibold text-gray-700 dark:text-white mb-1">Jumlah</label>
                        <input type="number" name="jumlah" id="jumlah" required min="1"
                               class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none"
                               value="{{ old('jumlah', $barang->jumlah) }}">
                    </div>
                    <div>
                        <label for="satuan" class="block font-semibold text-gray-700 dark:text-white mb-1">Satuan</label>
                        <input type="text" name="satuan" id="satuan"
                               class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none"
                               value="{{ old('satuan', $barang->satuan) }}">
                    </div>
                </div>

                {{-- Sumber Barang --}}
                <div>
                    <label for="sumber_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Sumber Barang</label>
                    <select name="sumber_barang" id="sumber_barang" required
                            class="w-full px-4 py-2 border border-pink-300 rounded focus:outline-none">
                        @foreach(['Pengadaan', 'Hibah', 'Pembelian'] as $option)
                            <option value="{{ $option }}" {{ old('sumber_barang', $barang->sumber_barang) == $option ? 'selected' : '' }}>
                                {{ $option }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Harga</label>
                    <input type="number" name="harga_barang" id="harga_barang" min="0"
                           class="w-full px-4 py-2 border border-orange-300 rounded focus:outline-none"
                           value="{{ old('harga_barang', $barang->harga_barang) }}">
                </div>

                {{-- Bidang --}}
                <div>
                    <label for="bidang_id" class="block font-semibold text-gray-700 dark:text-white mb-1">Bidang</label>
                    <select name="bidang_id" id="bidang_id" required
                            class="w-full px-4 py-2 border border-indigo-300 rounded focus:outline-none">
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ old('bidang_id', optional($barang->bidangs->first())->id) == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="block font-semibold text-gray-700 dark:text-white mb-1">Keterangan</label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none">{{ old('keterangan', $barang->keterangan) }}</textarea>
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="gambar" class="block font-semibold text-gray-700 dark:text-white mb-1">Gambar Barang</label>
                    @if ($barang->gambar)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang" class="h-32 rounded border">
                            <p class="text-xs text-gray-400 mt-1">* Biarkan kosong jika tidak ingin mengganti gambar.</p>
                        </div>
                    @endif
                    <input type="file" name="gambar" id="gambar" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none">
                </div>

                {{-- Tombol --}}
                <div class="flex justify-between items-center mt-6">
                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition duration-200">
                        Update
                    </button>
                    <a href="{{ route('admin.barang.index') }}"
                       class="text-gray-600 dark:text-gray-300 hover:underline">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
