@extends('layouts.admin')

@section('title', 'Proses Aduan Barang')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📋 Proses Aduan Barang</h1>

    {{-- Belum Diproses --}}
    <div class="mb-10 bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-x-auto">
        <div class="px-6 py-3 border-b font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
            ⏳ Belum Diproses
        </div>
        <div class="p-4">
            <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-100">
                <thead class="bg-blue-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Pengadu</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Jenis Aduan</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Foto</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $menunggu = $aduans->where('status', 'menunggu'); @endphp
                    @forelse ($menunggu as $aduan)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} border-t">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $aduan->user->name ?? $aduan->nama_pengadu ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $aduan->barang->nama_barang ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $aduan->jenis_aduan }}</td>
                            <td class="px-4 py-2">{{ $aduan->deskripsi }}</td>
                            <td class="px-4 py-2">
                                @if ($aduan->foto)
                                    <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Aduan" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($aduan->tanggal_aduan)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2 text-center">
                                <div class="flex justify-center gap-2">
                                  <form action="{{ route('admin.aduan.update-status', $aduan->id) }}" method="POST">
    @csrf
    <input type="hidden" name="status" value="diterima">
    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs">
        ✅ Terima
    </button>
</form>


                                    <form action="{{ route('admin.aduan.update-status', $aduan->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs">
                                            ❌ Tolak
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-300">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Sudah Diproses --}}
    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-x-auto">
        <div class="px-6 py-3 border-b font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
            ✅ Sudah Diproses
        </div>
        <div class="p-4">
            <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-100">
                <thead class="bg-blue-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Nama Pengadu</th>
                        <th class="px-4 py-2">Barang</th>
                        <th class="px-4 py-2">Jenis Aduan</th>
                        <th class="px-4 py-2">Deskripsi</th>
                        <th class="px-4 py-2">Foto</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @php $diproses = $aduans->whereIn('status', ['diterima', 'ditolak']); @endphp
                    @forelse ($diproses as $aduan)
                        <tr class="{{ $loop->odd ? 'bg-white' : 'bg-gray-50' }} border-t">
                            <td class="px-4 py-2 text-center">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2">{{ $aduan->user->name ?? $aduan->nama_pengadu ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $aduan->barang->nama_barang ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $aduan->jenis_aduan }}</td>
                            <td class="px-4 py-2">{{ $aduan->deskripsi }}</td>
                            <td class="px-4 py-2">
                                @if ($aduan->foto)
                                    <img src="{{ asset('storage/' . $aduan->foto) }}" alt="Foto Aduan" class="w-16 h-16 object-cover rounded">
                                @else
                                    <span class="text-gray-400 italic">Tidak ada</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($aduan->tanggal_aduan)->format('d-m-Y') }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded 
                                    @if($aduan->status == 'diterima') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($aduan->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-4 text-center text-gray-500 dark:text-gray-300">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
