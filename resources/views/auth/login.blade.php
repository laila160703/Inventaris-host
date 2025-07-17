@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-cyan-400 via-blue-500 to-pink-500 px-4">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Login</h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">
                        <i class="fas fa-user"></i>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                        class="pl-10 pr-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="relative">
                    <span class="absolute left-3 top-2.5 text-gray-500">
                        <i class="fas fa-lock"></i>
                    </span>
                    <input type="password" name="password" id="password" required
                        class="pl-10 pr-4 py-2 w-full border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember & Forgot --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" name="remember"
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-600">Remember me</label>
                </div>

                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">
                    Forgot password?
                </a>
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full py-2 text-white font-semibold rounded bg-gradient-to-r from-cyan-500 to-pink-500 hover:opacity-90 transition">
                LOGIN
            </button>

            {{-- Social --}}
            <div class="text-center mt-6 text-sm text-gray-500">Or Sign Up Using</div>
            <div class="flex justify-center gap-4 mt-2">
                <div class="w-8 h-8 bg-blue-800 rounded-full"></div>
                <div class="w-8 h-8 bg-red-500 rounded-full"></div>
                <div class="w-8 h-8 bg-blue-400 rounded-full"></div>
                <div class="w-8 h-8 bg-gradient-to-r from-cyan-500 to-pink-500 rounded-full"></div>
            </div>
        </form>
    </div>
</div>
@endsection
