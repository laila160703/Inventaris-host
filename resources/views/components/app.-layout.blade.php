<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Inventaris' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white" x-data="{ open: true }">

    <div class="min-h-screen flex flex-col">

        <!-- Header -->
        <header class="bg-blue-500 dark:bg-blue-700 shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold text-blue-900 dark:text-white">
                {{ $title ?? 'Dashboard' }}
            </h1>

            <!-- User Profile Dropdown -->
            <div class="relative" x-data="{ dropdownOpen: false }">
                <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-2 focus:outline-none">
                    <svg class="w-6 h-6 text-gray-600 dark:text-gray-300" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-sm text-gray-700 dark:text-gray-300">{{ Auth::user()->name }}</span>
                </button>

                <!-- Dropdown -->
                <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded shadow-md z-50">
                    <a href="/profile" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-600">Profil</a>
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

        <!-- Sidebar & Main Content -->
        <div class="flex flex-1">
            <!-- Sidebar -->
            @include('components.sidebar')

            <!-- Main Content -->
            <main class="flex-1 p-6 transition-all">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>
</html>
