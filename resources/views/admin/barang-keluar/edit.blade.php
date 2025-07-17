@extends('layouts.admin')

@section('title', 'Edit Barang Keluar')

@section('content')
<div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8">
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">✏️ Edit Barang Keluar</h2>

    <div class="bg-white dark:bg-gray-900 shadow-md rounded-lg p-6">
        <form action="{{ route('admin.barang-keluar.update', $barangKeluar->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            {{-- Kode Transaksi --}}
            <div>
                <label for="kode_transaksi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kode Transaksi</label>
                <input type="text" name="kode_transaksi" id="kode_transaksi" value="{{ $barangKeluar->kode_transaksi }}" readonly
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Barang --}}
            <div>
                <label for="barang_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Barang</label>
                <select name="barang_id" id="barang_id" required
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white">
                    <option value="">-- Pilih Barang --</option>
                    @foreach ($barangs as $barang)
                        <option value="{{ $barang->id }}"
                            data-satuan="{{ $barang->satuan }}"
                            {{ $barangKeluar->barang_id == $barang->id ? 'selected' : '' }}>
                            {{ $barang->nama_barang }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Satuan --}}
            <div>
                <label for="satuan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Satuan</label>
                <input type="text" id="satuan" name="satuan" readonly
                    value="{{ $barangKeluar->barang->satuan ?? '' }}"
                    class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Tanggal Keluar --}}
            <div>
                <label for="tanggal_keluar" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" required
                    value="{{ $barangKeluar->tanggal_keluar }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Jumlah --}}
            <div>
                <label for="jumlah" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jumlah</label>
                <input type="number" name="jumlah" required min="1"
                    value="{{ $barangKeluar->jumlah }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Penerima --}}
            <div>
                <label for="penerima" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Penerima</label>
                <input type="text" name="penerima" required
                    value="{{ $barangKeluar->penerima }}"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white" />
            </div>

            {{-- Keterangan --}}
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan</label>
                <textarea name="keterangan" rows="3"
                    class="mt-1 block w-full rounded-md border-gray-300 dark:bg-gray-800 dark:text-white">{{ $barangKeluar->keterangan }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.barang-keluar.index') }}" class="bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-white px-4 py-2 rounded">❌ Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">💾 Update</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectBarang = document.getElementById('barang_id');
        const satuanInput = document.getElementById('satuan');

        function updateSatuan() {
            const selected = selectBarang.options[selectBarang.selectedIndex];
            satuanInput.value = selected.getAttribute('data-satuan') || '';
        }

        updateSatuan();
        selectBarang.addEventListener('change', updateSatuan);
    });
</script>
@endpush
@endsection
