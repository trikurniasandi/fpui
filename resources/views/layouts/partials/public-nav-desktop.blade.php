@foreach ($items as $item)
    @php
        $children = $item['children'] ?? [];
        $patterns = (array) ($item['active_pattern'] ?? []);
        $isActive = !empty($patterns) && request()->routeIs(...$patterns);
    @endphp

    @if (empty($children))
        <a href="{{ route($item['route'], $item['params'] ?? []) }}"
            class="{{ $level === 0 ? 'inline-block whitespace-nowrap' : 'block px-4 py-2 text-sm' }} transition duration-200
                {{ $isActive ? 'text-emerald-700 font-semibold' : 'text-gray-700 hover:text-emerald-700' }}
                {{ $level > 0 && $isActive ? 'bg-emerald-50' : '' }}
                {{ $level > 0 && !$isActive ? 'hover:bg-gray-50' : '' }}">
            {{ $item['label'] }}
        </a>
    @else
        <div class="relative" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">

            <button type="button" @click="open = !open" @keydown.escape="open = false" :aria-expanded="open"
                class="{{ $level === 0 ? 'inline-flex whitespace-nowrap' : 'w-full flex px-4 py-2 text-sm' }} items-center justify-between gap-1 transition duration-200
                    {{ $isActive ? 'text-emerald-700 font-semibold' : 'text-gray-700 hover:text-emerald-700' }}
                    {{ $level > 0 && $isActive ? 'bg-emerald-50' : '' }}
                    {{ $level > 0 && !$isActive ? 'hover:bg-gray-50' : '' }}">

                {{ $item['label'] }}

                <svg class="w-4 h-4 shrink-0 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-cloak x-show="open" x-transition.opacity
                class="absolute z-50 {{ $level === 0 ? 'left-0 top-full pt-2' : 'left-full top-0 ml-1' }}">

                <div class="w-64 bg-white border border-gray-100 rounded-xl shadow-xl py-2">
                    @include('layouts.partials.public-nav-desktop', [
                        'items' => $children,
                        'level' => $level + 1,
                    ])
                </div>

            </div>
        </div>
    @endif
@endforeach
