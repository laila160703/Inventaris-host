@extends('layouts.admin')

@section('title', 'Data Kategori')

@section('content')
<h2 class="text-2xl font-bold text-blue-800 dark:text-white mb-6 flex items-center gap-2">
    📁 Data Kategori
</h2>

<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 shadow-md rounded-xl p-6">
@if (session('success'))
    <div class="mb-4 flex items-center gap-2 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded-lg shadow-sm">
        <span class="text-xl">✅</span>
        <span class="text-sm font-medium">
            {{ session('success') }}
        </span>
    </div>
@endif

            <!-- Tombol Tambah -->
            <div class="mb-4 flex justify-end">
                <a href="{{ route('admin.kategori.create') }}"
                   class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow transition-all duration-200">
                    ➕ Tambah Kategori
                </a>
            </div>

            <!-- Tabel -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800 border rounded-lg shadow-sm">
                    <thead class="bg-blue-100 dark:bg-gray-700 text-blue-900 dark:text-gray-200 uppercase text-sm tracking-wide">
                        <tr>
                            <th class="px-6 py-3 text-left">📂 Nama Kategori</th>
                            <th class="px-6 py-3 text-left">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kategories as $kategori)
                            <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-blue-50 dark:hover:bg-gray-700 transition">
                                <td class="px-6 py-3">{{ $kategori->nama }}</td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.kategori.edit', $kategori->id) }}"
                                           class="inline-flex items-center gap-1 bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm shadow">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm shadow">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    ❌ Tidak ada data kategori.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>
@endsection
