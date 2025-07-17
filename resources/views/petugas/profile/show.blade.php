@extends('layouts.petugas')

@section('title', 'Profil Petugas')

@section('content')
<div class="max-w-xl mx-auto bg-gradient-to-br from-blue-50 via-white to-indigo-50 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 p-8 rounded-3xl shadow-2xl">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-blue-800 dark:text-white flex items-center gap-2">👤 Profil Petugas</h2>
        <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-3 py-1 rounded-full dark:bg-blue-700 dark:text-white">Petugas</span>
    </div>

    <div class="space-y-5">
        <div class="bg-white dark:bg-gray-700 p-4 rounded-xl shadow-sm">
            <label class="text-sm text-gray-600 dark:text-gray-300 font-medium">Nama:</label>
            <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ auth()->user()->name }}</p>
        </div>

        <div class="bg-white dark:bg-gray-700 p-4 rounded-xl shadow-sm">
            <label class="text-sm text-gray-600 dark:text-gray-300 font-medium">Email:</label>
            <p class="text-lg font-semibold text-gray-800 dark:text-white">{{ auth()->user()->email }}</p>
        </div>

        <div class="bg-white dark:bg-gray-700 p-4 rounded-xl shadow-sm">
            <label class="text-sm text-gray-600 dark:text-gray-300 font-medium">Role:</label>
            <p class="text-lg font-semibold text-gray-800 dark:text-white capitalize">{{ auth()->user()->role }}</p>
        </div>
    </div>

    <div class="mt-6 text-right">
        <a href="{{ route('petugas.dashboard') }}"
           class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl transition shadow-md">
            ⬅️ Kembali ke Dashboard
        </a>
    </div>
</div>
@endsection
