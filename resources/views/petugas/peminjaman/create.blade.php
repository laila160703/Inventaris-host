@extends('layouts.petugas')

@section('title', 'Tambah Peminjaman')

@section('content')
<div class="container mx-auto p-4">
    <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 shadow-xl rounded-xl p-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6 flex items-center gap-2">
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Data Peminjaman
        </h1>

       <form method="POST" action="{{ route('petugas.peminjaman.store') }}" enctype="multipart/form-data">

            @csrf

            {{-- Nama Peminjam --}}
            <div class="mb-4">
                <label for="nama_peminjam" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Peminjam</label>
                <input type="text" name="nama_peminjam" id="nama_peminjam"
                    value="{{ auth()->user()->name }}" readonly
                    class="mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-900 dark:text-white dark:border-gray-700" />
            </div>

            {{-- Barang --}}
            <div class="mb-4">
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Barang</label>
                <select name="barang_id" id="barang_id" required
                    class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white dark:border-gray-700 @error('barang_id') border-red-500 @enderror">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror

                {{-- Preview Foto --}}
                <div id="previewFotoBarang" class="mt-4 hidden">
                    <img src="" alt="Preview Foto Barang" class="h-32 w-auto rounded shadow border border-gray-300 object-cover">
                </div>
            </div>

            {{-- Jumlah --}}
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" value="{{ old('jumlah') }}" min="1" required
                    class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white dark:border-gray-700 @error('jumlah') border-red-500 @enderror">
                @error('jumlah')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Pinjam & Kembali --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label for="tanggal_pinjam" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white dark:border-gray-700 @error('tanggal_pinjam') border-red-500 @enderror">
                    @error('tanggal_pinjam')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="tanggal_kembali" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Tanggal Kembali</label>
                    <input type="date" name="tanggal_kembali" id="tanggal_kembali" value="{{ old('tanggal_kembali') }}" required
                        class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white dark:border-gray-700 @error('tanggal_kembali') border-red-500 @enderror">
                    @error('tanggal_kembali')
                        <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Status --}}
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Status</label>
                <input type="text" value="Menunggu" disabled
                    class="mt-1 block w-full px-4 py-2 border rounded-lg bg-gray-100 text-gray-500 cursor-not-allowed dark:bg-gray-900 dark:text-white dark:border-gray-700" />
                <input type="hidden" name="status" value="Menunggu">
            </div>
        {{-- Upload Foto Peminjaman (Opsional) --}}
        <div class="mb-6">
            <label for="foto" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Upload Foto Barang (Opsional)</label>
            <input type="file" name="foto" id="foto" accept="image/*"
                class="mt-1 block w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:text-white dark:border-gray-700 @error('foto') border-red-500 @enderror">
            @error('foto')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>



            {{-- Tombol --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('petugas.peminjaman.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg text-sm">Batal</a>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm">Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const barangData = @json($barangs->mapWithKeys(fn($b) => [$b->id => $b->foto]));
    const selectBarang = document.getElementById('barang_id');
    const previewFoto = document.getElementById('previewFotoBarang').querySelector('img');
    const previewContainer = document.getElementById('previewFotoBarang');

    selectBarang.addEventListener('change', function () {
        const foto = barangData[this.value];
        if (foto) {
            previewFoto.src = `/storage/barang/${foto}`;
            previewContainer.classList.remove('hidden');
        } else {
            previewFoto.src = '';
            previewContainer.classList.add('hidden');
        }
    });
</script>
@endpush
