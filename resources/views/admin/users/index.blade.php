@extends('layouts.admin')

@section('title', 'Manajemen Users')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 dark:text-white leading-tight">
        👥 Data Pengguna
    </h2>
@endsection

@section('content')
<div class="py-4">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

            {{-- Notifikasi --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded shadow-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Header dan Filter --}}
            <div class="flex flex-wrap justify-between items-center mb-4 gap-3">
                <a href="{{ route('admin.users.create') }}"
                   class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    <span class="mr-2">➕</span> Tambah User
                </a>

                <form method="GET" action="{{ route('admin.users.index') }}" class="flex items-center space-x-2">
                    <label for="per_page" class="text-gray-700 dark:text-gray-200 font-medium">Tampilkan</label>
                    <select name="per_page" id="per_page" onchange="this.form.submit()"
                            class="border border-gray-300 px-2 py-1 rounded">
                        @foreach ([10, 25, 50, 100] as $limit)
                            <option value="{{ $limit }}" {{ request('per_page') == $limit ? 'selected' : '' }}>
                                {{ $limit }} data
                            </option>
                        @endforeach
                    </select>
                </form>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border border-gray-300 border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-blue-100 text-blue-900">
                        <tr>
                            <th class="border px-4 py-2">No</th>
                            <th class="border px-4 py-2">👤 Profil</th>
                            <th class="border px-4 py-2">✉️ Email</th>
                            <th class="border px-4 py-2">🏢 Bidang</th>
                            <th class="border px-4 py-2">🔑 Role</th>
                            <th class="border px-4 py-2">⚙️ Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800">
                        @forelse ($users as $index => $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                <td class="border px-4 py-2 text-center">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="border px-4 py-2">
                                    <div class="flex items-center gap-3">
                                        @if ($user->photo && file_exists(public_path('gambar/' . $user->photo)))
                                            <img src="{{ asset('gambar/' . $user->photo) }}" alt="Foto"
                                                 class="w-12 h-12 rounded-full object-cover border shadow">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff"
                                                 alt="Avatar"
                                                 class="w-10 h-10 rounded-full shadow border">
                                        @endif
                                        <span class="font-semibold text-sm text-gray-700 dark:text-gray-200">
                                            {{ $user->name }}
                                        </span>
                                    </div>
                                </td>
                                <td class="border px-4 py-2 text-sm">{{ $user->email }}</td>

                                {{-- Tampilkan Bidang --}}
                                <td class="border px-4 py-2 text-sm">
                                    @if($user->role === 'petugas' && $user->bidang)
                                        {{ $user->bidang->nama }}
                                    @elseif($user->role === 'petugas')
                                        <span class="text-red-500 italic">Belum dipilih</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                {{-- Role --}}
                                <td class="border px-4 py-2 text-center">
                                    @php
                                        $badgeColor = match($user->role) {
                                            'admin' => 'bg-red-200 text-red-800',
                                            'petugas' => 'bg-yellow-200 text-yellow-800',
                                            'kepala' => 'bg-green-200 text-green-800',
                                            default => 'bg-gray-200 text-gray-800',
                                        };
                                    @endphp
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full {{ $badgeColor }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                {{-- Aksi --}}
                                <td class="border px-4 py-2 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                            ✏️ Edit
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus user ini?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm">
                                                🗑️ Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-3 text-center text-gray-500">
                                    Tidak ada pengguna ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Info dan Pagination --}}
            <div class="mt-6 text-sm text-gray-600 dark:text-gray-300 flex flex-col sm:flex-row sm:justify-between sm:items-center">
                <div>
                    Menampilkan {{ $users->firstItem() }} - {{ $users->lastItem() }} dari {{ $users->total() }} pengguna
                </div>
                <div class="mt-2 sm:mt-0">
                    {{ $users->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
