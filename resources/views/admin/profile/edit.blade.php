@extends('layouts.admin')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 p-8 rounded-xl shadow-md border border-blue-200 dark:border-gray-700">
    <h2 class="text-2xl font-bold text-blue-800 dark:text-blue-300 mb-6">✏️ Edit Profil Admin</h2>

   <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                   class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300
                          dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   required>
            @error('name')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                   class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300
                          dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                   required>
            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Username -->
        <div>
            <label for="username" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}"
                   class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300
                          dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            @error('username')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>


        <!-- Foto Profil -->
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">Foto Profil</label>
            <div class="flex items-center space-x-4">
                <img src="{{ $user->photo ? asset('storage/profile/' . $user->photo) : asset('images/default-avatar.png') }}"
                    alt="Foto Profil" class="w-16 h-16 rounded-full object-cover border-2 border-blue-400">
                <input type="file" name="photo"
                    class="block w-full text-sm text-gray-600 file:mr-4 file:py-2 file:px-4
                            file:rounded-lg file:border-0 file:text-sm file:font-semibold
                            file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100
                            dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600">
            </div>
            @error('photo')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Ubah Password -->
<div x-data="{ show: false }">
    <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password Baru (opsional)</label>
    <div class="relative">
        <input :type="show ? 'text' : 'password'" name="password" id="password"
               class="mt-1 block w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-blue-300
                      dark:bg-gray-700 dark:border-gray-600 dark:text-white pr-10">

        <button type="button" @click="show = !show" tabindex="-1"
                class="absolute right-2 top-2 text-gray-600 dark:text-gray-300 focus:outline-none">
            <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
            <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.957 9.957 0 012.563-4.304M15 12a3 3 0 00-3-3m0 0a3 3 0 013 3m-3 0a3 3 0 01-3 3m3-3l6.364 6.364M3 3l18 18" />
            </svg>
        </button>
    </div>
    @error('password')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>



        <!-- Tombol -->
        <div class="flex justify-end gap-3 mt-6">
            <a href="{{ route('admin.profile.show') }}"
               class="px-5 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">
               Batal
            </a>
            <button type="submit"
                    class="px-5 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition shadow">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
