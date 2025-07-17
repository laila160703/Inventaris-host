@extends('layouts.admin')

@section('title', 'Tambah Barang Keluar')

@section('content')
<div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">➖ Tambah Barang Keluar</h2>

    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6">
        <form action="{{ route('admin.barang-keluar.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Kode Transaksi --}}
            <div>
                <label for="kode_transaksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Transaksi</label>
                <input type="text" name="kode_transaksi" id="kode_transaksi" value="{{ $kode_transaksi }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Barang --}}
            <div>
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Barang</label>
                <select name="barang_id" id="barang_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}" data-satuan="{{ $barang->satuan }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                <input type="text" id="satuan" name="satuan" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Tanggal Keluar --}}
            <div>
                <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" required min="1"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" />
            </div>

          {{-- Penerima (Bidang) --}}
            <div>
                <label for="penerima" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Bidang Penerima</label>
                <select name="penerima" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach ($bidangs as $bidang)
                        <option value="{{ $bidang->id }}">{{ $bidang->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white"></textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.barang-keluar.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white px-4 py-2 rounded">❌ Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectBarang = document.getElementById('barang_id');
        const satuanInput = document.getElementById('satuan');

        selectBarang.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            satuanInput.value = selectedOption.getAttribute('data-satuan') || '';
        });
    });
</script>
@endpush
@endsection
