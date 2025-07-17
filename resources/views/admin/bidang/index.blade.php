@extends('layouts.admin')

@section('title', 'Data Bidang')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-900 shadow-lg rounded-xl p-6">

            {{-- Judul Halaman --}}
            <h2 class="text-2xl font-bold text-blue-800 dark:text-white mb-6 flex items-center gap-2">
                🧩 Data Bidang
            </h2>

            {{-- Alert --}}
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    ✅ {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    ❌ {{ session('error') }}
                </div>
            @endif

            {{-- Tombol dan Pencarian --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                <a href="{{ route('admin.bidang.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                    ➕ Tambah Bidang
                </a>

                <form method="GET" action="{{ route('admin.bidang.index') }}" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari bidang..."
                           class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm" />
                    <button type="submit"
                            class="inline-flex items-center gap-1 bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition shadow">
                        🔍 Cari
                    </button>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-xl shadow">
                <table class="min-w-full text-left text-sm">
                    <thead class="bg-blue-100 dark:bg-gray-800 text-blue-900 dark:text-white uppercase tracking-wide">
                        <tr>
                            <th class="px-6 py-3">📂 Nama Bidang</th>
                            <th class="px-6 py-3">📝 Deskripsi</th>
                            <th class="px-6 py-3">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse ($bidangs as $bidang)
                            <tr class="hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                                <td class="px-6 py-4 font-medium text-gray-800 dark:text-gray-100">{{ $bidang->nama }}</td>
                                <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $bidang->deskripsi }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-2">
                                        {{-- Edit --}}
                                        <a href="{{ route('admin.bidang.edit', $bidang->id) }}"
                                           class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-black px-3 py-1.5 rounded-md shadow text-sm">
                                            ✏️ Edit
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('admin.bidang.destroy', $bidang->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus bidang ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded-md shadow text-sm">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    ⚠️ Tidak ada data bidang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $bidangs->links() }}
            </div>

        </div>
    </div>
</div>
@endsection
