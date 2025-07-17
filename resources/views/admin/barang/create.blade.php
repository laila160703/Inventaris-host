@extends('layouts.admin')

@section('title', 'Tambah Barang')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Barang
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

            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Nama Barang --}}
                <div>
                    <label for="nama_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Nama Barang</label>
                    <input list="namaBarangs" name="nama_barang" id="nama_barang" required
                           class="w-full border rounded px-4 py-2 bg-yellow-50 border-yellow-300 focus:outline-none"
                           placeholder="Ketik atau pilih nama barang">
                    <datalist id="namaBarangs">
                        @foreach($namaBarangs as $barang)
                            <option value="{{ $barang->nama_barang }}">
                        @endforeach
                    </datalist>
                </div>

                {{-- Kode Barang --}}
                <div>
                    <label for="kode_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Kode Barang</label>
                    <input type="text" name="kode_barang" id="kode_barang" required
                           class="w-full border rounded px-4 py-2 bg-blue-50 border-blue-300 focus:outline-none"
                           placeholder="Kode otomatis">
                </div>

                {{-- Kategori --}}
                <div>
                    <label for="kategori_id" class="block font-semibold text-gray-700 dark:text-white mb-1">Kategori</label>
                    <select name="kategori_id" id="kategori_id" required
                            class="w-full border rounded px-4 py-2 bg-purple-50 border-purple-300 focus:outline-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Merk / Type --}}
                <div>
                    <label for="merk_type" class="block font-semibold text-gray-700 dark:text-white mb-1">Merk / Type</label>
                    <input type="text" name="merk_type" value="{{ old('merk_type') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none"
                           placeholder="Contoh: Epson L3110">
                </div>

                {{-- Jumlah dan Satuan --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jumlah" class="block font-semibold text-gray-700 dark:text-white mb-1">Jumlah</label>
                        <input type="number" name="jumlah" required min="1" value="{{ old('jumlah') }}"
                               class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none"
                               placeholder="Jumlah barang">
                    </div>
                    <div>
                        <label for="satuan" class="block font-semibold text-gray-700 dark:text-white mb-1">Satuan</label>
                        <input type="text" name="satuan" value="{{ old('satuan') }}"
                               class="w-full px-4 py-2 border border-green-300 rounded focus:outline-none"
                               placeholder="pcs/unit/buah">
                    </div>
                </div>

                {{-- Sumber Barang --}}
                <div>
                    <label for="sumber_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Sumber Barang</label>
                    <select name="sumber_barang" required
                            class="w-full px-4 py-2 border border-pink-300 rounded focus:outline-none">
                        <option value="">-- Pilih Sumber --</option>
                        <option value="Pengadaan" {{ old('sumber_barang') == 'Pengadaan' ? 'selected' : '' }}>Pengadaan</option>
                        <option value="Hibah" {{ old('sumber_barang') == 'Hibah' ? 'selected' : '' }}>Hibah</option>
                        <option value="Pembelian" {{ old('sumber_barang') == 'Pembelian' ? 'selected' : '' }}>Pembelian</option>
                    </select>
                </div>

                {{-- Harga --}}
                <div>
                    <label for="harga_barang" class="block font-semibold text-gray-700 dark:text-white mb-1">Harga</label>
                    <input type="number" name="harga_barang" min="0" value="{{ old('harga_barang') }}"
                           class="w-full px-4 py-2 border border-orange-300 rounded focus:outline-none"
                           placeholder="Contoh: 1500000">
                </div>

                {{-- Bidang --}}
                <div>
                    <label for="bidang_id" class="block font-semibold text-gray-700 dark:text-white mb-1">Bidang</label>
                    <select name="bidang_id" required
                            class="w-full px-4 py-2 border border-indigo-300 rounded focus:outline-none">
                        <option value="">-- Pilih Bidang --</option>
                        @foreach($bidangs as $bidang)
                            <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                                {{ $bidang->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="block font-semibold text-gray-700 dark:text-white mb-1">Keterangan</label>
                    <textarea name="keterangan" rows="3"
                              class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none"
                              placeholder="Tulis keterangan tambahan">{{ old('keterangan') }}</textarea>
                </div>

                {{-- Gambar --}}
                <div>
                    <label for="gambar" class="block font-semibold text-gray-700 dark:text-white mb-1">Gambar Barang</label>
                    <input type="file" name="gambar" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none">
                </div>

                {{-- Tombol --}}
                <div class="flex justify-between items-center mt-6">
                    <button type="submit"
                            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition duration-200">
                        Simpan
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

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $('#nama_barang').on('change', function () {
        const nama = $(this).val();
        if (nama) {
            $.get('/get-kode-barang/' + encodeURIComponent(nama), function (data) {
                $('#kode_barang').val(data.kode_barang);
            });
        } else {
            $('#kode_barang').val('');
        }
    });
</script>

@endpush
