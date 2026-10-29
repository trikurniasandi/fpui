<section class="max-w-4xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ $section['title'] }}
        </h2>
    @endif

    @if (!empty($section['items']))
        <ul class="divide-y divide-gray-100 border border-gray-100 rounded-2xl bg-white overflow-hidden">
            @foreach ($section['items'] as $item)
                <li class="px-6 py-5 flex flex-col sm:flex-row sm:items-start gap-2">
                    <div class="flex-1">
                        <div class="font-medium text-gray-900">{{ $item['title'] }}</div>
                        @if (!empty($item['text']))
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $item['text'] }}</p>
                        @endif
                    </div>
                    @if (!empty($item['meta']))
                        <span class="text-xs text-gray-500 whitespace-nowrap">{{ $item['meta'] }}</span>
                    @endif
                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state :message="$section['empty'] ?? 'Daftar pada bagian ini belum tersedia.'" />
    @endif

</section>
