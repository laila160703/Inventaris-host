@extends('layouts.admin')

@section('header')
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
        Edit Barang Masuk
    </h2>
@endsection

@section('content')
<div class="py-6 max-w-2xl mx-auto sm:px-6 lg:px-8">
    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6 space-y-6">

        {{-- Kode Transaksi --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Transaksi</label>
            <input type="text" value="{{ $barangMasuk->kode_transaksi }}" readonly
                class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <form action="{{ route('admin.barang-masuk.update', $barangMasuk->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Barang --}}
            <div>
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Barang</label>
                <select name="barang_id" id="barang_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}"
                            data-satuan="{{ $barang->satuan }}"
                            {{ $barangMasuk->barang_id == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
                @error('barang_id')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                <input type="text" id="satuan" name="satuan" readonly
                    value="{{ $barangMasuk->barang->satuan ?? '' }}"
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
            </div>

            {{-- Tanggal Masuk --}}
            <div>
                <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" id="tanggal_masuk" required
                    value="{{ $barangMasuk->tanggal_masuk }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                @error('tanggal_masuk')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" required min="1"
                    value="{{ $barangMasuk->jumlah }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500" />
                @error('jumlah')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
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
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white focus:ring-blue-500 focus:border-blue-500">{{ $barangMasuk->keterangan }}</textarea>
                @error('keterangan')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex justify-end gap-3 pt-4">
                <a href="{{ route('admin.barang-masuk.index') }}"
                   class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white text-sm font-medium rounded-md">
                    ❌ Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md">
                    💾 Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const barangSelect = document.getElementById('barang_id');
        const satuanInput = document.getElementById('satuan');

        function updateSatuan() {
            const selectedOption = barangSelect.options[barangSelect.selectedIndex];
            satuanInput.value = selectedOption.getAttribute('data-satuan') || '';
        }

        updateSatuan();
        barangSelect.addEventListener('change', updateSatuan);
    });
</script>
@endpush
