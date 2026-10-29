@foreach ($items as $item)
    @php
        $children = $item['children'] ?? [];
        $patterns = (array) ($item['active_pattern'] ?? []);
        $isActive = !empty($patterns) && request()->routeIs(...$patterns);
    @endphp

    @if (empty($children))
        <a href="{{ route($item['route'], $item['params'] ?? []) }}"
            style="padding-left: {{ $level * 16 }}px"
            class="block py-2 pr-2 transition
                {{ $isActive ? 'text-emerald-700 font-semibold' : 'text-gray-700 hover:text-emerald-700' }}">
            {{ $item['label'] }}
        </a>
    @else
        <div x-data="{ open: false }" class="{{ $level === 0 ? 'border-t pt-1' : '' }}">

            <button type="button" @click="open = !open" :aria-expanded="open"
                style="padding-left: {{ $level * 16 }}px"
                class="w-full flex items-center justify-between gap-2 py-2 pr-2 transition
                    {{ $isActive ? 'text-emerald-700 font-semibold' : 'text-gray-700 hover:text-emerald-700' }}">

                {{ $item['label'] }}

                <svg class="w-4 h-4 shrink-0 transition-transform" :class="{ 'rotate-180': open }" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <div x-cloak x-show="open" x-transition class="space-y-1">
                @include('layouts.partials.public-nav-mobile', [
                    'items' => $children,
                    'level' => $level + 1,
                ])
            </div>

        </div>
    @endif
@endforeach
