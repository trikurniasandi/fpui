@props([
    'title',
    'subtitle' => null,
    'eyebrow' => null,
    'breadcrumb' => [],
])

<section class="bg-gradient-to-b from-emerald-50 to-white border-b border-emerald-100/70">
    <div class="max-w-5xl mx-auto px-6 pt-10 pb-16 text-center">

        @if (!empty($breadcrumb))
            <div class="mb-8 flex justify-center">
                <x-breadcrumb :items="$breadcrumb" />
            </div>
        @endif

        @if ($eyebrow)
            <span
                class="inline-block text-xs font-semibold uppercase tracking-wide px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                {{ $eyebrow }}
            </span>
        @endif

        <h1 class="mt-5 text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
            {{ $title }}
        </h1>

        @if ($subtitle)
            <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                {{ $subtitle }}
            </p>
        @endif

    </div>
</section>
