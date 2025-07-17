@extends('layouts.admin')

@section('title', 'Profil Admin')

@section('content')
<div class="max-w-3xl mx-auto bg-gradient-to-br from-blue-50 to-white dark:from-gray-800 dark:to-gray-900 p-8 rounded-2xl shadow-lg border border-blue-200 dark:border-gray-700">
    
    <!-- Foto & Header -->
    <div class="flex flex-col items-center mb-8">
        <img src="{{ $user->photo ? asset('storage/profile/' . $user->photo) : asset('images/profil.jpg') }}" 
        class="h-28 w-28 rounded-full object-cover border-4 border-blue-400 shadow mb-4"
        alt="Foto Profil Admin">
        <h2 class="text-3xl font-bold text-blue-800 dark:text-blue-300">👤 Profil Admin</h2>
        <p class="text-sm text-gray-600 dark:text-gray-300">Detail informasi akun anda</p>
    </div>

    <!-- Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Nama -->
        <x-profile-card icon="🧑" label="Nama" value="{{ $user->name }}" />

        <!-- Email -->
        <x-profile-card icon="📧" label="Email" value="{{ $user->email }}" />

        <!-- Role -->
        <x-profile-card icon="🔐" label="Peran (Role)" value="{{ ucfirst($user->role) }}" />

        <!-- Tanggal Daftar -->
        <x-profile-card icon="📅" label="Tanggal Daftar" value="{{ $user->created_at->format('d M Y') }}" />

    
    </div>

    <!-- Tombol -->
    <div class="mt-10 flex justify-center gap-4">
        <a href="{{ route('admin.profile.edit') }}"
           class="inline-flex items-center px-6 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition shadow">
            ✏️ Edit Profil
        </a>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow">
            ⬅️ Kembali
        </a>
    </div>
</div>
@endsection
