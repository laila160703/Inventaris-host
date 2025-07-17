@extends('layouts.public')

@section('title', 'Detail Barang')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg">
        {{-- Gambar Barang --}}
        <div class="flex justify-center mb-6">
            @if ($barang->gambar)
                <img src="{{ asset('storage/' . $barang->gambar) }}"
                     alt="Gambar Barang"
                     class="w-64 h-64 object-cover rounded-md shadow-md border border-gray-300">
            @else
                <div class="w-64 h-64 bg-gray-200 flex items-center justify-center rounded-md shadow">
                    <span class="text-gray-500 italic">Tidak ada gambar</span>
                </div>
            @endif
        </div>

        {{-- Informasi Barang --}}
        <h2 class="text-2xl font-bold text-center mb-6">{{ $barang->nama_barang }}</h2>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-sm border border-gray-300 shadow-sm rounded-lg">
                <tbody class="divide-y divide-gray-200">
                    <tr><td class="font-semibold p-2 w-1/3 text-right">Kode Barang:</td><td class="p-2">{{ $barang->kode_barang }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Kategori:</td><td class="p-2">{{ $barang->kategori->nama ?? '-' }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Merk / Tipe:</td><td class="p-2">{{ $barang->merk_type }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Jumlah:</td><td class="p-2">{{ $barang->jumlah }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Stok:</td><td class="p-2">{{ $barang->stok }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Satuan:</td><td class="p-2">{{ $barang->satuan }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Sumber:</td><td class="p-2">{{ $barang->sumber_barang }}</td></tr>
                    <tr><td class="font-semibold p-2 text-right">Harga:</td><td class="p-2">Rp{{ number_format($barang->harga_barang, 0, ',', '.') }}</td></tr>
                   <tr>
                    <td class="font-semibold p-2 text-right">Status:</td>
                    <td class="p-2">
                        @if ($barang->stok > 0)
                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Tersedia</span>
                        @else
                            <span class="inline-block bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Habis</span>
                        @endif
                    </td>
                </tr>
                    <tr><td class="font-semibold p-2 text-right">Keterangan:</td><td class="p-2">{{ $barang->keterangan ?? '-' }}</td></tr>
                    <tr>
                        <td class="font-semibold p-2 text-right align-top">Bidang:</td>
                        <td class="p-2">
                            @forelse ($barang->bidangs as $bidang)
                                <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded mr-1 mb-1">
                                    {{ $bidang->nama }}
                                </span>
                            @empty
                                <span class="text-gray-400 italic">-</span>
                            @endforelse
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
