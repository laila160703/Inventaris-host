@extends('layouts.admin')

@section('title', 'Kelola Ajuan Peminjaman')

@section('content')
<div class="container mx-auto p-4">

    {{-- 🔍 Pencarian --}}
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">📋 Ajuan Peminjaman</h1>
    <input type="text" id="searchInput" placeholder="Cari nama peminjam atau barang..."
        class="w-full md:w-1/3 px-4 py-2 mb-4 border border-gray-300 dark:border-gray-700 rounded-lg focus:ring focus:ring-blue-200 dark:bg-gray-900 dark:text-white" />

    {{-- 📋 Tabel Ajuan Menunggu --}}
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow mb-10">
        <table class="min-w-full table-auto border border-gray-300 dark:border-gray-600" id="dataTable">
            <thead class="bg-blue-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border text-sm">No</th>
                    <th class="px-4 py-2 border text-sm">Nama Peminjam</th>
                    <th class="px-4 py-2 border text-sm">Barang</th>
                    <th class="px-4 py-2 border text-sm">Stok Tersisa</th>
                    <th class="px-4 py-2 border text-sm">Foto</th>
                    <th class="px-4 py-2 border text-sm">Jumlah</th>
                    <th class="px-4 py-2 border text-sm">Tgl. Pinjam</th>
                    <th class="px-4 py-2 border text-sm">Status</th>
                    <th class="px-4 py-2 border text-center text-sm">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
                @php $ajuanBaru = $ajuan->where('status', 'Menunggu'); @endphp
                @forelse ($ajuanBaru as $pinjam)
                <tr class="hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->barang->nama_barang ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center">{{ $pinjam->barang->stok ?? '0' }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if ($pinjam->foto)
                            <img src="{{ asset('storage/' . $pinjam->foto) }}" class="h-12 mx-auto rounded shadow" alt="Foto Peminjaman">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border text-center">{{ $pinjam->jumlah }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->tanggal_pinjam }}</td>
                    <td class="px-4 py-2 border text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                            {{ $pinjam->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <div class="flex justify-center gap-2">
                            <form action="{{ route('admin.peminjaman.terima', $pinjam->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit"
                                    class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm">Terima</button>
                            </form>
                            <form action="{{ route('admin.peminjaman.tolak', $pinjam->id) }}" method="POST">
                                @csrf @method('PUT')
                                <button type="submit"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Tolak</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-6 text-gray-500 dark:text-gray-300">Tidak ada ajuan baru.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📚 Riwayat Peminjaman --}}
    <h2 class="text-xl font-semibold text-gray-800 dark:text-white mb-4">📚 Riwayat Peminjaman</h2>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-xl shadow">
        <table class="min-w-full table-auto border border-gray-300 dark:border-gray-600">
            <thead class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white">
                <tr>
                    <th class="px-4 py-2 border text-sm">No</th>
                    <th class="px-4 py-2 border text-sm">Nama Peminjam</th>
                    <th class="px-4 py-2 border text-sm">Barang</th>
                    <th class="px-4 py-2 border text-sm">Foto</th>
                    <th class="px-4 py-2 border text-sm">Jumlah</th>
                    <th class="px-4 py-2 border text-sm">Tgl. Pinjam</th>
                    <th class="px-4 py-2 border text-sm">Tgl. Kembali</th>
                    <th class="px-4 py-2 border text-sm">Kondisi Barang</th>
                    <th class="px-4 py-2 border text-sm">Status</th>
                    <th class="px-4 py-2 border text-sm text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100">
               @php $riwayat = $ajuan->whereIn('status', ['Dipinjam', 'Dikembalikan', 'Ditolak', 'Menunggu Verifikasi']); @endphp
                @forelse ($riwayat as $pinjam)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->user->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->barang->nama_barang ?? '-' }}</td>
                    <td class="px-4 py-2 border text-center">
                        @if ($pinjam->foto)
                            <img src="{{ asset('storage/' . $pinjam->foto) }}" class="h-12 mx-auto rounded shadow" alt="Foto Peminjaman">
                        @else
                            <span class="text-gray-400 italic">Tidak ada</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border text-center">{{ $pinjam->jumlah }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->tanggal_pinjam }}</td>
                    <td class="px-4 py-2 border">{{ $pinjam->tanggal_kembali ?? '-' }}</td>
                    <td class="px-4 py-2 border">
                        {{ $pinjam->status === 'Dikembalikan' ? $pinjam->kondisi_barang : '-' }}
                    </td>
                    <td class="px-4 py-2 border text-center">
                        <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                            {{ $pinjam->status == 'Dipinjam' ? 'bg-yellow-100 text-yellow-800' :
                               ($pinjam->status == 'Dikembalikan' ? 'bg-green-100 text-green-800' :
                               'bg-red-100 text-red-800') }}">
                            {{ $pinjam->status }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border text-center">
                       @if ($pinjam->status == 'Menunggu Verifikasi')
                      <form action="{{ route('admin.peminjaman.verifikasi', $pinjam->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tanggal_kembali" value="{{ now()->format('Y-m-d') }}">
                        <input type="hidden" name="kondisi_barang" value="Baik">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 text-xs rounded">
                            ✅ Verifikasi
                        </button>
                    </form>

                    @else
                        <span class="text-gray-400 text-xs italic">-</span>
                    @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-6 text-gray-500 dark:text-gray-300">
                        Tidak ada riwayat peminjaman.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- 📄 Pagination --}}
    <div class="mt-4">
        {{ $ajuan->links() }}
    </div>
</div>
@endsection

{{-- 🔍 Script Pencarian --}}
@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        const filter = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dataTable tbody tr');
        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush
