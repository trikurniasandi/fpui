<section class="max-w-4xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ $section['title'] }}
        </h2>
    @endif

    @if (!empty($section['items']))
        <ul class="space-y-4">
            @foreach ($section['items'] as $item)
                <li
                    class="flex flex-col sm:flex-row sm:items-center gap-4 bg-white border border-gray-100 rounded-2xl p-5 shadow-sm">

                    <div
                        class="w-11 h-11 shrink-0 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 21h10a2 2 0 002-2V7.5L14.5 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM14 3v5h5" />
                        </svg>
                    </div>

                    <div class="flex-1">
                        <div class="font-medium text-gray-900">{{ $item['title'] }}</div>
                        @if (!empty($item['description']))
                            <p class="text-sm text-gray-600 mt-1 leading-relaxed">{{ $item['description'] }}</p>
                        @endif
                    </div>

                    @if (!empty($item['url']))
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener"
                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg border border-emerald-200 text-sm font-medium text-emerald-700 hover:bg-emerald-50 transition">
                            Unduh
                            @if (!empty($item['meta']))
                                <span class="ml-2 text-xs text-emerald-600/70">{{ $item['meta'] }}</span>
                            @endif
                        </a>
                    @else
                        <span
                            class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-xs font-medium text-gray-500">
                            Segera tersedia
                        </span>
                    @endif

                </li>
            @endforeach
        </ul>
    @else
        <x-empty-state :message="$section['empty'] ?? 'Berkas pada bagian ini belum tersedia.'" />
    @endif

</section>
