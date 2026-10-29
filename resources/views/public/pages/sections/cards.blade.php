@php
    $columns = $section['columns'] ?? 3;
    $gridClass = match ((int) $columns) {
        2 => 'sm:grid-cols-2',
        4 => 'sm:grid-cols-2 lg:grid-cols-4',
        default => 'sm:grid-cols-2 lg:grid-cols-3',
    };
@endphp

<section class="max-w-6xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-10">
            {{ $section['title'] }}
        </h2>
    @endif

    @if (!empty($section['items']))
        <div class="grid grid-cols-1 {{ $gridClass }} gap-6">

            @foreach ($section['items'] as $item)
                <div class="bg-white border border-gray-100 rounded-2xl p-7 shadow-sm hover:shadow-md transition">
                    @if (!empty($item['number']))
                        <span
                            class="w-11 h-11 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-base font-bold">
                            {{ $item['number'] }}
                        </span>
                    @endif

                    <h3 class="text-base font-semibold text-gray-900 {{ !empty($item['number']) ? 'mt-4' : '' }} mb-2">
                        {{ $item['title'] }}
                    </h3>

                    @if (!empty($item['text']))
                        <p class="text-sm text-gray-600 leading-relaxed">{{ $item['text'] }}</p>
                    @endif

                    @if (!empty($item['url']))
                        <a href="{{ $item['url'] }}"
                            class="inline-flex mt-4 text-sm font-medium text-emerald-700 hover:text-emerald-800">
                            {{ $item['link_label'] ?? 'Selengkapnya' }} →
                        </a>
                    @endif
                </div>
            @endforeach

        </div>
    @else
        <x-empty-state :message="$section['empty'] ?? 'Daftar pada bagian ini belum tersedia.'" />
    @endif

</section>
