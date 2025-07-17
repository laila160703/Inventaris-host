<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIBARAKOM')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white" x-data="{ open: true }">
<div class="min-h-screen flex flex-col">

   <!-- Bagian dalam <body> sudah disesuaikan -->

<!-- Navbar -->
<header class="fixed top-0 left-0 w-full z-50 bg-blue-600 shadow px-6 py-4 flex justify-between items-center text-white">
    <!-- Logo Baru -->
    <div class="flex items-center space-x-4">
        <img src="{{ asset('images/inventaris.png') }}" alt="Logo Inventaris"
             class="h-14 w-14 object-cover rounded-full border-2 border-white shadow-lg">
        <div>
            <h1 class="text-2xl font-bold">Inventaris Barang</h1>
            <p class="text-xs text-blue-100">Diskominfo Barito Kuala</p>
        </div>
    </div>


        <!-- Profil -->
        <div class="relative" x-data="{ dropdownOpen: false }">
            <button @click="dropdownOpen = !dropdownOpen"
                    class="flex items-center space-x-2 hover:text-yellow-300 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ auth()->user()->name }}</span>
            </button>

            <!-- Dropdown -->
            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                 class="absolute right-0 mt-3 w-48 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg shadow-xl z-50 transition">
                <a href="{{ auth()->user()->role === 'admin' ? route('admin.profile.show') : route('petugas.profile.show') }}"
                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-blue-100 dark:hover:bg-gray-600">
                    Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-blue-100 dark:hover:bg-gray-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>


    <!-- Body -->
    <div class="flex flex-1 pt-20">
        <!-- Sidebar -->
      <!-- Sidebar -->
<aside class="fixed top-20 left-0 h-[calc(100vh-5rem)] w-72 overflow-y-auto bg-blue-300 shadow-lg px-4 py-6 text-white">
    <nav class="space-y-5 text-sm font-medium">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
            <span class="text-xl">🏠</span> <span>Dashboard</span>
        </a>

        <!-- MASTER -->
        <div>
            <h3 class="text-xs text-white/90 font-bold uppercase tracking-wide mb-2">Master</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.kategori.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">📁</span> <span>Kategori</span>
                </a>
                <a href="{{ route('admin.bidang.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">🧩</span> <span>Bidang</span>
                </a>
                <a href="{{ route('admin.barang.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">📦</span> <span>Data Barang</span>
                </a>
            </div>
        </div>

        <!-- TRANSAKSI -->
        <div class="mt-4">
            <h3 class="text-xs text-white/90 font-bold uppercase tracking-wide mb-2">Transaksi</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.barang-masuk.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">➕</span> <span>Barang Masuk</span>
                </a>
                <a href="{{ route('admin.barang-keluar.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">➖</span> <span>Barang Keluar</span>
                </a>
                <a href="{{ route('admin.peminjaman.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">📋</span> <span>Peminjaman</span>
                </a>
                <a href="{{ route('admin.aduan.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">❗</span> <span>Aduan Barang</span>
                </a>
            </div>
        </div>

        <!-- LAPORAN -->
        <div class="mt-4">
            <h3 class="text-xs text-white/90 font-bold uppercase tracking-wide mb-2">Laporan</h3>
            <a href="{{ route('admin.laporan.laporan') }}"
               class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                <span class="text-xl">📑</span> <span>Laporan</span>
            </a>
        </div>

        <!-- PENGATURAN -->
        <div class="mt-4">
            <h3 class="text-xs text-white/90 font-bold uppercase tracking-wide mb-2">Pengaturan</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.profile.show') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">👤</span> <span>Profil Saya</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="flex items-center gap-3 px-4 py-3 rounded-full bg-blue-100 text-blue-900 hover:bg-white hover:scale-105 transition-transform duration-200 shadow-lg">
                    <span class="text-xl">👥</span> <span>Kelola Pengguna</span>
                </a>
            </div>
        </div>

    </nav>
</aside>



        <!-- Konten -->
        <main class="ml-72 w-full overflow-y-auto p-6 bg-white dark:bg-gray-800 rounded-lg">
            @yield('content')
        </main>
                @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: false,
                    position: 'top',
                });
            });
        </script>
        @endif

        @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 2500,
                    showConfirmButton: false,
                    toast: false,
                    position: 'top',
                });
            });
        </script>
        @endif

    </div>
</div>
@stack('scripts')
</body>
</html>
