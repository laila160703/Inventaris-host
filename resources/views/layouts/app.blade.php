<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inventaris</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white" x-data="{ open: true }">

<div class="min-h-screen flex flex-col">

    <!-- Navbar -->
   <header class="bg-blue-600 shadow px-2 py-2 flex justify-between items-center text-white">
    <!-- Kiri: Logo dan Nama -->
    <div class="flex items-center space-x-3">
        <img src="{{ asset('images/logo-sibarakom.png') }}" alt="Logo" class="h-20 w-auto">
        <span class="text-xl font-bold">SIBARAKOM</span>
    </div>


    <!-- Kanan: Profil Dropdown -->
    <div class="relative" x-data="{ dropdownOpen: false }">
        <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span>{{ auth()->user()->name }}</span>
        </button>

        <!-- Dropdown -->
        <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
             class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded shadow-md z-50">
            <a href="/profile"
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


    <div class="flex flex-1">

        <!-- Sidebar -->
        <aside :class="open ? 'w-64' : 'w-16'"
               class="bg-gradient-to-b from-blue-900 to-blue-400 text-white transition-all duration-300 p-4 shadow-lg flex flex-col">

            <!-- Toggle -->
            <button @click="open = !open" class="mb-6 hover:text-yellow-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- NAV -->
            <nav class="space-y-2 text-sm font-medium">

                <!-- Dashboard -->
                <a href="/dashboard" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 12l2-2m0 0l7-7 7 7m-9 2v8"/>
                    </svg>
                    <span x-show="open">Dashboard</span>
                </a>

                <!-- Data Master -->
                <div x-data="{ openMaster: true }">
                    <button @click="openMaster = !openMaster"
                            class="flex justify-between items-center w-full px-2 py-2 hover:bg-blue-700 rounded">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M4 6h16M4 12h8m-8 6h16"/>
                            </svg>
                            <span x-show="open">Data Master</span>
                        </div>
                        <svg :class="openMaster ? 'rotate-90' : ''"
                             class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <div x-show="openMaster" class="mt-1 space-y-1 pl-2">
                        <a href="/kategori"
                           class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-yellow-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M4 4h16v4H4zM4 10h10v10H4zM16 10h4v10h-4z"/>
                            </svg>
                            <span x-show="open">Kategori</span>
                        </a>
                        <a href="/bidang"
                           class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-purple-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 3h18v2H3V3zm0 6h18v2H3V9zm0 6h12v2H3v-2z"/>
                            </svg>
                            <span x-show="open">Bidang</span>
                        </a>
                        <a href="/barang"
                           class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-indigo-300" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M5 4h14v2H5zM4 8h16v12H4z"/>
                            </svg>
                            <span x-show="open">Data Barang</span>
                        </a>
                    </div>
                </div>

                <!-- Transaksi -->
                <div x-data="{ openTransaksi: true }">
                    <button @click="openTransaksi = !openTransaksi"
                            class="flex justify-between items-center w-full px-2 py-2 hover:bg-blue-700 rounded">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4l3 3"/>
                            </svg>
                            <span x-show="open">Transaksi</span>
                        </div>
                        <svg :class="openTransaksi ? 'rotate-90' : ''"
                             class="w-4 h-4 transform transition-transform" fill="none" stroke="currentColor"
                             viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                    <div x-show="openTransaksi" class="mt-1 space-y-1 pl-2">
                        <a href="/barang-masuk" class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-green-300" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 4v16m8-8H4"/>
                            </svg>
                            <span x-show="open">Barang Masuk</span>
                        </a>
                        <a href="/barang-keluar" class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-red-300" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M20 12H4m8-8v16"/>
                            </svg>
                            <span x-show="open">Barang Keluar</span>
                        </a>
                        <a href="/peminjaman" class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-pink-300" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M8 17l4-4 4 4m0-8l-4 4-4-4"/>
                            </svg>
                            <span x-show="open">Peminjaman</span>
                        </a>
                        <a href="/aduan" class="flex items-center space-x-2 hover:bg-blue-500 p-2 rounded">
                            <svg class="w-5 h-5 text-orange-300" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span x-show="open">Aduan Barang</span>
                        </a>
                    </div>
                </div>

                <!-- Laporan -->
                <a href="/laporan" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded">
                    <svg class="w-5 h-5 text-cyan-300" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 17v-6h13M9 5v6h13"/>
                    </svg>
                    <span x-show="open">Laporan</span>
                </a>

                <!-- Profile -->
                <a href="/profile" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded mt-8">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span x-show="open">Profile</span>
                </a>

                <!-- Settings -->
                <a href="/settings" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9.75 3a.75.75 0 01.75.75v.75h3V3.75a.75.75 0 011.5 0V4.5h.75a.75.75 0 010 1.5h-.75v3h.75a.75.75 0 010 1.5h-.75v.75a.75.75 0 01-1.5 0V10.5h-3v.75a.75.75 0 01-1.5 0V10.5H9v-.75a.75.75 0 010-1.5h.75V6H9a.75.75 0 010-1.5h.75V3.75A.75.75 0 019.75 3z"/>
                    </svg>
                    <span x-show="open">Settings</span>
                </a>
            </nav>
        </aside>

        <!-- Content -->
        <main class="flex-1 p-6 bg-white dark:bg-gray-800 rounded-lg shadow">
            @yield('content')
        </main>

    </div>
</div>
@stack('scripts')

</body>
</html>
