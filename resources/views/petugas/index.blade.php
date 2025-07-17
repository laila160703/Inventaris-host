@extends('layouts.app')  {{-- kalau kamu pakai layout utama --}}

@section('title', 'Daftar Pengguna')

@section('content')
<h2 class="text-2xl font-bold mb-4">Daftar Pengguna</h2>

@if(session('success'))
    <div class="bg-green-200 p-3 rounded mb-4 text-green-700">
        {{ session('success') }}
    </div>
@endif

<table class="min-w-full bg-white rounded shadow">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b">No</th>
            <th class="py-2 px-4 border-b">Nama</th>
            <th class="py-2 px-4 border-b">Email</th>
            <th class="py-2 px-4 border-b">Role</th>
            <th class="py-2 px-4 border-b">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse($users as $index => $user)
        <tr>
            <td class="py-2 px-4 border-b">{{ $users->firstItem() + $index }}</td>
            <td class="py-2 px-4 border-b">{{ $user->name }}</td>
            <td class="py-2 px-4 border-b">{{ $user->email }}</td>
            <td class="py-2 px-4 border-b">{{ $user->role }}</td>
            <td class="py-2 px-4 border-b">
                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-600 hover:underline">Edit</a> |
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus user ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="py-4 px-4 text-center">Data pengguna kosong.</td>
        </tr>
        @endforelse
    </tbody>
</table>

<div class="mt-4">
    {{ $users->links() }}
</div>
@endsection
