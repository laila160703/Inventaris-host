@props(['icon', 'bg' => 'gray', 'label', 'value'])

@php
    $bgColor = [
        'blue' => 'bg-blue-100 dark:bg-blue-800 text-blue-900 dark:text-white',
        'green' => 'bg-green-100 dark:bg-green-800 text-green-900 dark:text-white',
        'red' => 'bg-red-100 dark:bg-red-800 text-red-900 dark:text-white',
        'purple' => 'bg-purple-100 dark:bg-purple-800 text-purple-900 dark:text-white',
        'gray' => 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white',
    ][$bg] ?? 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-white';
@endphp

<div class="{{ $bgColor }} rounded-lg p-5 shadow flex items-center space-x-4">
    {{-- Ikon --}}
    <div class="p-3 bg-white dark:bg-gray-900 rounded-full shadow">
        @if ($icon === 'users')
            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m6-4a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
        @elseif ($icon === 'folder-open')
            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M3 7v4a1 1 0 001 1h16a1 1 0 011-1V7a1 1 0 00-1-1h-7l-2-2H4a1 1 0 00-1 1z" /></svg>
        @elseif ($icon === 'exclamation-triangle')
            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M10.29 3.86L1.82 18a1 1 0 00.86 1.5h18.64a1 1 0 00.86-1.5L13.71 3.86a1 1 0 00-1.72 0zM12 9v4m0 4h.01" /></svg>
        @elseif ($icon === 'boxes')
            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M3 7v4a1 1 0 001 1h16a1 1 0 011-1V7a1 1 0 00-1-1h-7l-2-2H4a1 1 0 00-1 1zM3 17h18v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4z" /></svg>
        @else
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M4 6h16M4 12h16M4 18h16" /></svg>
        @endif
    </div>

    {{-- Label dan Value --}}
    <div>
        <p class="text-sm font-medium">{{ $label }}</p>
        <p class="text-2xl font-bold">{{ $value }}</p>
    </div>
</div>
