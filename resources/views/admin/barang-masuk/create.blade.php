@extends('layouts.admin')

@section('title', 'Tambah Barang Masuk')

@section('content')
<div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
    {{-- Judul Halaman --}}
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white leading-tight mb-4">
        ➕ Tambah Barang Masuk
    </h2>

    {{-- Form Tambah Barang Masuk --}}
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 mb-8">
        <form action="{{ route('admin.barang-masuk.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Kode Transaksi --}}
            <div>
                <label for="kode_transaksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Transaksi</label>
                <input type="text" id="kode_transaksi" name="kode_transaksi" value="{{ $kode_transaksi }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm bg-gray-100 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
            </div>


            {{-- Barang --}}
            <div>
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Barang</label>
                <select name="barang_id" id="barang_id" required
                        class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}">
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" required
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                @error('tanggal_masuk')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" required min="1"
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                @error('jumlah')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                <input type="text" id="satuan" name="satuan" readonly
                       class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm bg-gray-100 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
            </div>

           {{-- Supplier --}}
            <div>
                <label for="supplier" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Supplier</label>
                <input type="text" name="supplier" id="supplier" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                @error('supplier')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>


            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500"></textarea>
                @error('keterangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.barang-masuk.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-sm text-gray-700 dark:text-white font-medium rounded-md">
                    ❌ Batal
                </a>
                <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                    💾 Simpan
                </button>
            </div>
        </form>
    </div>

    {{-- Tabel Riwayat Barang Masuk Terbaru --}}
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">
            📋 Data Barang Masuk Terbaru
        </h3>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 dark:border-gray-700 text-sm">
                <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Tanggal</th>
                        <th class="px-4 py-2 border">Nama Barang</th>
                        <th class="px-4 py-2 border">Jumlah</th>
                        <th class="px-4 py-2 border">Supplier</th>
                        <th class="px-4 py-2 border">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900">
                    @forelse ($barangMasuks as $masuk)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border">{{ $masuk->tanggal_masuk }}</td>
                            <td class="px-4 py-2 border">{{ $masuk->barang->nama_barang }}</td>
                            <td class="px-4 py-2 border">{{ $masuk->jumlah }}</td>
                            <td class="px-4 py-2 border">{{ $masuk->supplier }}</td>
                            <td class="px-4 py-2 border">{{ $masuk->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-center border text-gray-500">
                                Belum ada data.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Script untuk auto isi satuan --}}
@push('scripts')
<script>
    document.getElementById('barang_id').addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        const satuan = selected.getAttribute('data-satuan') || '';
        document.getElementById('satuan').value = satuan;
    });
</script>
@endpush
@endsection
