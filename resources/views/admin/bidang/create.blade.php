@extends('layouts.admin')

@section('title', 'Tambah Bidang')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Tambah Bidang</h2>

                <form action="{{ route('admin.bidang.store') }}" method="POST">
                    @csrf

                    {{-- Nama Bidang --}}
                    <div class="mb-4">
                        <label for="nama" class="block text-gray-700 dark:text-white font-bold mb-2">Nama Bidang</label>
                        <input type="text" name="nama" id="nama" required
                            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Masukkan nama bidang">
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-4">
                        <label for="deskripsi" class="block text-gray-700 dark:text-white font-bold mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                            placeholder="Deskripsi singkat bidang (opsional)"></textarea>
                    </div>

                    {{-- Tombol --}}
                    <div class="flex justify-start items-center gap-3">
                        <button type="submit"
                            class="inline-flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 010 2h-3v3a1 1 0 01-2 0v-3H6a1 1 0 010-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            Simpan
                        </button>
                        <a href="{{ route('admin.bidang.index') }}"
                            class="text-gray-600 hover:text-blue-600 hover:underline transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
