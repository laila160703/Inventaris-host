@props(['href', 'label', 'icon', 'open'])

<a href="{{ $href }}" class="flex items-center space-x-2 hover:bg-blue-700 p-2 rounded transition">
    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
        @if ($icon === 'home')
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2 7-7 7 7 2 2M13 5v6h6" />
        @elseif ($icon === 'collection')
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7M4 17h16M4 21h16" />
        @elseif ($icon === 'plus')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
        @elseif ($icon === 'square')
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 4h16v16H4z" />
        @elseif ($icon === 'arrow-down')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l3-3m-3 3l-3-3M5 21h14" />
        @elseif ($icon === 'arrow-up')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21V9m0 0l-3 3m3-3l3 3M5 3h14" />
        @elseif ($icon === 'menu')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6" />
        @elseif ($icon === 'alert')
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2a4 4 0 018 0v2" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 12v.01" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M4 20h16v-2a6 6 0 00-12 0v2z" />
        @elseif ($icon === 'document')
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 5h14v14H5z M9 9h6M9 13h6M9 17h6" />
        @elseif ($icon === 'user')
            <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A4 4 0 0110 15h4a4 4 0 014.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        @elseif ($icon === 'cog')
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v1m0 14v1M5 12H4m16 0h-1m-7 4a4 4 0 100-8 4 4 0 000 8z" />
        @else
            <!-- Default icon kosong -->
        @endif
    </svg>
    <span x-show="open">{{ $label }}</span>
</a>
