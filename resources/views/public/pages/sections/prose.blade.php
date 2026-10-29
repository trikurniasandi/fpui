<section class="max-w-4xl mx-auto">

    @if (!empty($section['title']))
        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
            {{ $section['title'] }}
        </h2>
    @endif

    <div class="space-y-4 text-gray-700 leading-relaxed text-justify prose max-w-none">
        {!! $section['body'] ?? '' !!}
    </div>

</section>
