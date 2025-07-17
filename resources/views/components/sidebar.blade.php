<aside x-data="{ open: true }" :class="open ? 'w-64' : 'w-16'" class="bg-blue-200 text-black transition-all duration-300 p-4 shadow-lg flex flex-col">
    <button @click="open = !open" class="mb-6 text-white hover:text-yellow-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
    </button>

    <nav class="space-y-3">
        <x-sidebar-link href="/dashboard" label="Dashboard" icon="home" />
        <x-sidebar-link href="/kategori" label="Kategori" icon="collection" />
        <x-sidebar-link href="/bidang" label="Bidang" icon="plus" />
        <x-sidebar-link href="/barang" label="Data Barang" icon="square" />
        <x-sidebar-link href="/barang-masuk" label="Barang Masuk" icon="arrow-down" />
        <x-sidebar-link href="/barang-keluar" label="Barang Keluar" icon="arrow-up" />
        <x-sidebar-link href="/peminjaman" label="Peminjaman" icon="menu" />
        <x-sidebar-link href="/aduan" label="Aduan Barang" icon="alert" />
        <x-sidebar-link href="/laporan" label="Laporan" icon="document" />
    </nav>

    <div class="mt-auto space-y-3">
        <x-sidebar-link href="/profile" label="Profile" icon="user" />
        <x-sidebar-link href="/settings" label="Settings" icon="cog" />
    </div>
</aside>
