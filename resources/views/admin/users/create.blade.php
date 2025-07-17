@extends('layouts.admin')

@section('title', 'Tambah User')

@section('content')
<div class="max-w-xl mx-auto space-y-6">
    <h2 class="text-3xl font-bold text-blue-800">➕ Tambah User Baru</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5 bg-white dark:bg-gray-900 p-6 rounded-lg shadow-md">
        @csrf

        {{-- Nama --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
                required>
            @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
                required>
            @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Password</label>
            <input type="password" name="password"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
                required>
            @error('password') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300"
                required>
        </div>

        {{-- Role --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Role</label>
            <select name="role" class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300" required>
                <option value="">-- Pilih Role --</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
            @error('role') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Bidang (muncul hanya jika role petugas) --}}
        @if(isset($bidangs) && count($bidangs) > 0)
        <div id="bidang-field" style="display: none;">
            <label class="block font-semibold text-gray-700 dark:text-white">Bidang</label>
            <select name="bidang_id" id="bidang_id"
                    class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
                <option value="">-- Pilih Bidang --</option>
                @foreach($bidangs as $bidang)
                    <option value="{{ $bidang->id }}" {{ old('bidang_id') == $bidang->id ? 'selected' : '' }}>
                        {{ $bidang->nama }}
                    </option>
                @endforeach
            </select>
            @error('bidang_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>
        @endif



        {{-- Foto Profil --}}
        <div>
            <label class="block font-semibold text-gray-700 dark:text-white">Foto Profil (Opsional)</label>
            <input type="file" name="photo" accept="image/*"
                class="w-full px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            @error('photo') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
        </div>

        {{-- Tombol --}}
        <div class="pt-2">
            <button type="submit"
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow transition">
                💾 Simpan
            </button>
            <a href="{{ route('admin.users.index') }}" class="ml-4 text-gray-600 hover:underline">
                ❌ Batal
            </a>
        </div>
    </form>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.querySelector('select[name="role"]');
            const bidangField = document.getElementById('bidang-field');

            function toggleBidangField() {
                bidangField.style.display = roleSelect.value === 'petugas' ? 'block' : 'none';
            }

            roleSelect.addEventListener('change', toggleBidangField);
            toggleBidangField(); // Trigger awal saat halaman dimuat
        });
</script>

</div>
@endsection
