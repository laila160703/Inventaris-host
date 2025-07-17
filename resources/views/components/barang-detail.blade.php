@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
    ...


<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-xl rounded-2xl p-8">

            {{-- Tombol Aksi --}}
            <div class="flex justify-between items-center mb-6">
                <a href="{{ $backRoute }}">
                    <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                        ← Kembali
                    </button>
                </a>

                @if(Auth::user()->role === 'admin')
                <div class="flex space-x-2">
                    <a href="{{ route('barang.edit', $barang->id) }}">
                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            ✏️ Edit
                        </button>
                    </a>
                    <form action="{{ route('barang.destroy', $barang->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-lg shadow transition">
                            🗑️ Hapus
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- Gambar --}}
            @if($barang->gambar)
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $barang->gambar) }}" alt="Gambar Barang"
                     class="w-64 h-64 object-cover rounded-xl shadow-lg border border-gray-300 dark:border-gray-600">
            </div>
            @endif

            {{-- QR Code --}}
            <div class="flex justify-center mt-6">
                {!! QrCode::size(180)->generate(url('/public/barang/' . $barang->id)) !!}
            </div>
            <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-2">
                Scan QR Code untuk melihat halaman publik barang
            </p>

            {{-- Tabel Detail --}}
            <div class="overflow-x-auto mt-10">
                <table class="w-full border border-gray-300 dark:border-gray-600 rounded-lg overflow-hidden text-sm text-left">
                    <tbody class="text-gray-800 dark:text-gray-100 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $rows = [
                                'Kode Barang' => $barang->kode_barang,
                                'Nama Barang' => $barang->nama_barang,
                                'Kategori' => $barang->kategori->nama ?? '-',
                                'Merk / Type' => $barang->merk_type ?? '-',
                                'Jumlah' => $barang->jumlah,
                                'Satuan' => $barang->satuan ?? '-',
                                'Sumber Barang' => $barang->sumber_barang,
                                'Harga Barang' => 'Rp' . number_format($barang->harga_barang, 0, ',', '.'),
                                'Lokasi / Ruangan' => $barang->lokasi,
                                'Keterangan' => $barang->keterangan ?? '-',
                            ];
                        @endphp

                        @foreach($rows as $label => $value)
                        <tr class="even:bg-indigo-50 dark:even:bg-gray-700">
                            <th class="bg-indigo-100 dark:bg-gray-800 px-5 py-4 w-1/3 font-semibold text-indigo-900 dark:text-white">
                                {{ $label }}
                            </th>
                            <td class="px-5 py-4">
                                {{ $value }}
                            </td>
                        </tr>
                        @endforeach

                        {{-- Bidang --}}
                        <tr class="even:bg-indigo-50 dark:even:bg-gray-700">
                            <th class="bg-indigo-100 dark:bg-gray-800 px-5 py-4 font-semibold text-indigo-900 dark:text-white">
                                Bidang
                            </th>
                            <td class="px-5 py-4">
                                @forelse($barang->bidangs as $b)
                                    <span class="inline-block bg-emerald-100 text-emerald-800 dark:bg-emerald-800 dark:text-white text-xs font-medium px-3 py-1 rounded-full mr-2 mb-1 shadow-sm">
                                        {{ $b->nama }}
                                    </span>
                                @empty
                                    <span class="text-gray-500 italic">Tidak ada bidang</span>
                                @endforelse
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
