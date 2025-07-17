@extends('layouts.admin')

@section('title', 'Tambah Kategori Baru')

@section('content')
    <div class="py-4">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Tambah Kategori Baru</h2>

                <form method="POST" action="{{ route('admin.kategori.store') }}">
                    @csrf

                    <!-- Form Group for Nama Kategori -->
                    <div class="mb-6">
                        <label class="block text-gray-700 dark:text-white font-semibold text-lg mb-2" for="nama">
                            Nama Kategori
                        </label>
                        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required
                            class="w-full px-4 py-3 border rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-300 ease-in-out @error('nama') border-red-500 @enderror">

                        @error('nama')
                            <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end space-x-3">
                        <button type="submit"
                            class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 transition duration-200 ease-in-out">
                            Simpan
                        </button>
                        <a href="{{ route('admin.kategori.index') }}"
                            class="bg-gray-300 text-gray-800 px-6 py-3 rounded-lg shadow-md hover:bg-gray-400 focus:ring-2 focus:ring-gray-500 transition duration-200 ease-in-out">
                            Batal
                        </a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
