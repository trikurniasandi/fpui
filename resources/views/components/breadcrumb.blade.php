@props(['items' => []])

<nav aria-label="Breadcrumb" class="text-xs sm:text-sm text-gray-500">
    <ol class="flex flex-wrap items-center justify-center gap-1">
        <li>
            <a href="{{ route('home') }}" class="hover:text-emerald-700 transition">Beranda</a>
        </li>

        @foreach ($items as $item)
            <li class="text-gray-400" aria-hidden="true">/</li>
            <li>
                @if (!empty($item['route']))
                    <a href="{{ route($item['route'], $item['params'] ?? []) }}" class="hover:text-emerald-700 transition">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-700 font-medium">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
