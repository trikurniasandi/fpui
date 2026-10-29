<section class="max-w-4xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 mb-8">
            {{ $section['title'] }}
        </h2>
    @endif

    @if (!empty($section['items']))
        <ol class="relative border-l-2 border-emerald-100 pl-8 space-y-8">
            @foreach ($section['items'] as $index => $item)
                <li class="relative">
                    <span
                        class="absolute -left-[41px] top-0 w-8 h-8 rounded-full bg-emerald-600 text-white text-xs font-bold flex items-center justify-center">
                        {{ $index + 1 }}
                    </span>
                    <h3 class="font-semibold text-gray-900">{{ $item['title'] }}</h3>
                    @if (!empty($item['text']))
                        <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $item['text'] }}</p>
                    @endif
                </li>
            @endforeach
        </ol>
    @else
        <x-empty-state :message="$section['empty'] ?? 'Tahapan pada bagian ini belum tersedia.'" />
    @endif

</section>
