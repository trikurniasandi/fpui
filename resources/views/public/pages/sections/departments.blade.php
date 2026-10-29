@php
    $departments = config('public_content.departemen_items', []);
@endphp

<section class="max-w-6xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 text-center mb-10">
            {{ $section['title'] }}
        </h2>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        @foreach ($departments as $slug => $department)
            <a href="{{ route('organisasi.departemen.show', $slug) }}"
                class="group bg-white border border-gray-100 rounded-2xl p-7 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col">

                <span
                    class="w-11 h-11 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center text-base font-bold">
                    {{ $department['number'] }}
                </span>

                <h3 class="text-base font-semibold text-gray-900 mt-4 mb-2 group-hover:text-emerald-700 transition">
                    {{ $department['title'] }}
                </h3>

                <p class="text-sm text-gray-600 leading-relaxed flex-1">
                    {{ $department['summary'] }}
                </p>

                <span class="mt-5 text-sm font-medium text-emerald-700">Selengkapnya →</span>

            </a>
        @endforeach

    </div>

</section>
