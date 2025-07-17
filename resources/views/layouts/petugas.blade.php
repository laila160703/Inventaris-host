<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Petugas - SIBARAKOM</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white" x-data="{ open: true }">

    {{-- 🔷 Navbar Fixed --}}
    <header class="fixed top-0 left-0 right-0 z-40 bg-blue-400 shadow px-4 py-3 flex justify-between items-center text-white">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/inventaris.png') }}" alt="Logo Inventaris" class="h-16 w-16 object-cover rounded-full border-2 border-white shadow">
            <span class="text-xl font-bold">Petugas - Inventaris</span>
        </div>

        {{-- 🔽 Profil Dropdown --}}
        <div class="relative" x-data="{ dropdownOpen: false }">
            <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span>{{ auth()->user()->name }}</span>
            </button>
            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                 class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border rounded shadow-md z-50">
                <a href="{{ route('petugas.profile.show') }}"
                   class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">
                    Profil
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- 🔳 Sidebar & Main Content --}}
    <div class="flex pt-24 h-screen overflow-hidden">

        {{-- 📁 Sidebar Fixed --}}
        <aside :class="open ? 'w-64' : 'w-20'"
               class="fixed top-20 left-0 bottom-0 z-30 h-[calc(100vh-5rem)] overflow-y-auto bg-gradient-to-b from-blue-100 via-white to-blue-200 dark:from-gray-800 dark:via-gray-900 dark:to-gray-800 shadow-md transition-all duration-300 p-4 flex flex-col rounded-r-3xl">

            {{-- ☰ Toggle --}}
            <button @click="open = !open" class="mb-6 text-blue-800 dark:text-blue-300 hover:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <p x-show="open" class="text-xs uppercase text-gray-500 dark:text-gray-300 font-semibold mb-4 pl-3 tracking-wider">
                Menu Petugas
            </p>

            {{-- 📋 Menu --}}
            <nav class="space-y-3 text-sm font-semibold">
                {{-- Dashboard --}}
                <a href="/petugas/dashboard"
                   class="flex items-center space-x-2 p-3 rounded-full bg-blue-200 text-blue-900 dark:bg-blue-800 dark:text-white hover:scale-105 transform transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-9 2v8"/>
                    </svg>
                    <span x-show="open">Dashboard</span>
                </a>

                {{-- Data Barang --}}
                <a href="/petugas/barang"
                   class="flex items-center space-x-2 p-3 rounded-full bg-blue-100 text-blue-900 dark:bg-blue-700 dark:text-white hover:scale-105 transform transition shadow-md">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 4h14v2H5zM4 8h16v12H4z"/>
                    </svg>
                    <span x-show="open">Data Barang</span>
                </a>

                {{-- Peminjaman --}}
                <a href="/petugas/peminjaman"
                   class="flex items-center space-x-2 p-3 rounded-full bg-blue-200 text-blue-900 dark:bg-blue-700 dark:text-white hover:scale-105 transform transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l4-4 4 4m0-8l-4 4-4-4"/>
                    </svg>
                    <span x-show="open">Peminjaman</span>
                </a>

                {{-- Aduan --}}
                <a href="/petugas/aduan-barang"
                   class="flex items-center space-x-2 p-3 rounded-full bg-blue-300 text-blue-900 dark:bg-blue-700 dark:text-white hover:scale-105 transform transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span x-show="open">Aduan Barang</span>
                </a>

                {{-- 🔻 Divider --}}
                <div class="border-t border-gray-300 dark:border-gray-600 my-4"></div>

                {{-- Profil --}}
                <a href="{{ route('petugas.profile.show') }}"
                   class="flex items-center space-x-2 p-3 rounded-full bg-blue-100 text-blue-900 dark:bg-blue-600 dark:text-white hover:scale-105 transform transition shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="open">Profil</span>
                </a>
            </nav>
        </aside>

        {{-- 📄 Main Content (Scrollable) --}}
        <main class="ml-20 md:ml-64 w-full h-full overflow-y-auto px-6 py-4">
            @yield('content')
        </main>
    </div>

    @stack('scripts')
</body>
</html>
