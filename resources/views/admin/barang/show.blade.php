@extends('layouts.admin')

@section('title', 'Detail Barang')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            {{-- Kolom Gambar dan QR --}}
            <div class="space-y-4 text-center">
                {{-- Gambar Barang --}}
                @if ($barang->gambar)
                    <img src="{{ asset('storage/' . $barang->gambar) }}" 
                         alt="Gambar Barang"
                         class="w-64 h-64 object-cover mx-auto rounded border shadow">
                @else
                    <div class="w-64 h-64 bg-gray-200 flex items-center justify-center rounded mx-auto shadow">
                        <span class="text-gray-500 italic">Tidak ada gambar</span>
                    </div>
                @endif

                {{-- Tombol Cetak QR --}}
                <a href="{{ route('admin.barang.cetakQR', $barang->id) }}" target="_blank"
                   class="inline-block bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Cetak QR Code
                </a>

                {{-- QR Code --}}
                <div class="mt-2">
                    <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">QR Code Barang</p>
                    <div class="inline-block mt-1 p-2 bg-white dark:bg-gray-700 border rounded shadow">
                        {!! DNS2D::getBarcodeHTML(route('barang.public', $barang->id), 'QRCODE', 4, 4) !!}
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Scan untuk lihat detail publik</p>
                </div>
            </div>

            {{-- Kolom Detail --}}
            <div class="text-sm text-gray-800 dark:text-white space-y-4">
                <div class="grid grid-cols-2 gap-2">
                    <p class="font-semibold">Kode Barang:</p><p>{{ $barang->kode_barang }}</p>
                    <p class="font-semibold">Nama Barang:</p><p>{{ $barang->nama_barang }}</p>
                    <p class="font-semibold">Kategori:</p><p>{{ $barang->kategori->nama ?? '-' }}</p>
                    <p class="font-semibold">Merk / Type:</p><p>{{ $barang->merk_type ?? '-' }}</p>
                    <p class="font-semibold">Jumlah:</p><p>{{ $barang->jumlah }}</p>
                    <p class="font-semibold">Stok:</p><p>{{ $barang->stok }}</p>
                    <p class="font-semibold">Satuan:</p><p>{{ $barang->satuan }}</p>
                    <p class="font-semibold">Harga:</p><p>Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</p>
                    <p class="font-semibold">Sumber:</p><p>{{ $barang->sumber_barang }}</p>
                    <p class="font-semibold">Status:</p>
                    <p>
                        @if($barang->stok > 0)
                            <span class="bg-green-100 text-green-800 px-2 py-1 text-xs rounded">Tersedia</span>
                        @else
                            <span class="bg-red-100 text-red-800 px-2 py-1 text-xs rounded">Habis</span>
                        @endif
                    </p>
                    <p class="font-semibold">Keterangan:</p><p>{{ $barang->keterangan ?? '-' }}</p>
                </div>

                {{-- Daftar Bidang --}}
                <div>
                    <p class="font-semibold">Bidang:</p>
                    <div class="flex flex-wrap gap-1 mt-1">
                        @forelse ($barang->bidangs as $bidang)
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $bidang->nama }}</span>
                        @empty
                            <span class="text-gray-400 italic">Tidak ada bidang</span>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-6 text-right">
            <a href="{{ route('admin.barang.index') }}"
               class="inline-block bg-gray-600 hover:bg-gray-700 text-white px-5 py-2 rounded shadow">
                ⬅ Kembali ke Data Barang
            </a>
        </div>
    </div>
</div>
@endsection
