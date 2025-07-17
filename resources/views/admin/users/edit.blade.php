@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <h2 class="text-3xl font-bold text-yellow-700">✏️ Edit User</h2>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')

        {{-- Nama --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-yellow-400" required>
            @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-yellow-400" required>
            @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Password (kosongkan jika tidak diubah)</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-yellow-400">
            @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Role --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-yellow-400" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ $user->role === 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
            @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Foto Profil --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Foto Profil</label>
            @if ($user->photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/profile/' . $user->photo) }}" alt="Foto Profil" class="w-20 h-20 rounded-full shadow border">
                </div>
            @endif
            <input type="file" name="photo" accept="image/*"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-yellow-400">
            @error('photo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol --}}
        <div class="pt-2">
            <button type="submit"
                class="bg-yellow-600 hover:bg-yellow-700 text-white px-5 py-2 rounded shadow transition">
                🔄 Update
            </button>
            <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 hover:underline">
                ❌ Batal
            </a>
        </div>
    </form>
</div>
@endsection
