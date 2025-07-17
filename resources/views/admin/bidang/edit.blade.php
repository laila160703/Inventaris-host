@extends('layouts.admin')

@section('title', 'Edit Bidang')

@section('content')
    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-6">

                <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">Edit Bidang</h2>

                <form action="{{ route('admin.bidang.update', $bidang->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama Bidang --}}
                    <div>
                        <label for="nama" class="block text-gray-700 dark:text-white font-medium mb-2">Nama Bidang</label>
                        <input type="text" name="nama" id="nama"
                            value="{{ old('nama', $bidang->nama) }}" required
                            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('nama') border-red-500 @enderror">
                        @error('nama')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="deskripsi" class="block text-gray-700 dark:text-white font-medium mb-2">Deskripsi</label>
                        <textarea name="deskripsi" id="deskripsi" rows="4"
                            class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 @error('deskripsi') border-red-500 @enderror">{{ old('deskripsi', $bidang->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tombol --}}
                    <div class="flex items-center gap-4">
                        <button type="submit"
                            class="inline-flex items-center bg-green-600 hover:bg-green-700 text-white font-semibold px-6 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path d="M17.414 2.586a2 2 0 010 2.828l-9.5 9.5-4.243 1.414 1.414-4.243 9.5-9.5a2 2 0 012.828 0z" />
                                <path fill-rule="evenodd"
                                    d="M2 15.5A1.5 1.5 0 003.5 17h13a.5.5 0 000-1h-13a.5.5 0 01-.5-.5v-13a.5.5 0 00-1 0v13z"
                                    clip-rule="evenodd" />
                            </svg>
                            Update
                        </button>
                        <a href="{{ route('admin.bidang.index') }}"
                            class="text-gray-600 hover:text-blue-600 hover:underline transition">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
