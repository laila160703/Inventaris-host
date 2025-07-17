<div x-show="activeTab === 'masuk'">
    <div class="overflow-x-auto">
        <table class="min-w-full border text-sm">
            <thead class="bg-gray-200 text-gray-700">
                <tr>
                    <th class="border px-4 py-2">No</th>
                    <th class="border px-4 py-2">Kode</th>
                    <th class="border px-4 py-2">Nama Barang</th>
                    <th class="border px-4 py-2">Tanggal Masuk</th>
                    <th class="border px-4 py-2">Jumlah</th>
                    <th class="border px-4 py-2">Satuan</th>
                    <th class="border px-4 py-2">Supplier</th>
                    <th class="border px-4 py-2">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($barangMasuks as $index => $item)
                    <tr class="hover:bg-gray-100">
                        <td class="border px-4 py-2 text-center">{{ $index + 1 }}</td>
                        <td class="border px-4 py-2">{{ $item->kode_transaksi }}</td>
                        <td class="border px-4 py-2">{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item->tanggal_masuk }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->jumlah }}</td>
                        <td class="border px-4 py-2 text-center">{{ $item->barang->satuan ?? '-' }}</td>
                       <td class="border px-4 py-2">{{ $item->supplier ?? '-' }}</td>
                        <td class="border px-4 py-2">{{ $item->keterangan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center px-4 py-3">Tidak ada data.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
