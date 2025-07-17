<div x-show="activeTab === 'keluar'">
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm border border-gray-300">
            <thead class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
                <tr>
                    <th class="px-4 py-2 border text-center">No</th>
                    <th class="px-4 py-2 border">Kode Transaksi</th>
                    <th class="px-4 py-2 border">Nama Barang</th>
                    <th class="px-4 py-2 border">Tanggal Keluar</th>
                    <th class="px-4 py-2 border">Jumlah</th>
                    <th class="px-4 py-2 border">Penerima</th>
                    <th class="px-4 py-2 border">Keterangan</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-900">
                @forelse ($barangKeluars as $index => $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border font-mono text-blue-700">{{ $item->kode_transaksi }}</td>
                        <td class="px-4 py-2 border">{{ $item->barang->nama_barang }}</td>
                        <td class="px-4 py-2 border">
                            {{ \Carbon\Carbon::parse($item->tanggal_keluar)->translatedFormat('d F Y') }}
                        </td>
                        <td class="px-4 py-2 border text-center">
                            {{ $item->jumlah }} {{ $item->barang->satuan }}
                        </td>
                        <td class="px-4 py-2 border">{{ $item->bidang->nama ?? '-' }}</td>
                        <td class="px-4 py-2 border">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-gray-500 dark:text-gray-400 italic">
                            <div class="flex flex-col items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-6a3 3 0 013-3h1a3 3 0 013 3v6m-6 4h6" />
                                </svg>
                                <span>Belum ada data barang keluar.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
