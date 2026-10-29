@extends('layouts.public')

@section('title', $meta['label'])
@section('meta_description', $meta['meta_description'] ?? '')

@section('content')

    <x-page-hero :title="$meta['label']" :subtitle="$meta['intro'] ?? null" eyebrow="Publikasi" :breadcrumb="[
        ['label' => 'Publikasi'],
        ['label' => $meta['label']],
    ]" />

    <div class="max-w-7xl mx-auto px-6 py-14 space-y-12">

        @if ($publications->isEmpty())

            <x-empty-state :title="'Belum ada ' . Str::lower($meta['label'])"
                message="Konten pada kategori ini belum dipublikasikan. Silakan kembali lagi nanti." />

        @else

            @php
                $isMedia = ($meta['layout'] ?? 'grid') === 'media';
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($publications as $publication)
                    @php
                        if ($type === 'video') {
                            $href = $publication->video_url ?: '#';
                            $target = '_blank';
                        } elseif ($type === 'infographic') {
                            $href = $publication->thumbnail ? asset('storage/' . $publication->thumbnail) : '#';
                            $target = '_blank';
                        } else {
                            $href = route($meta['route_name'] . '.show', $publication->slug);
                            $target = null;
                        }
                    @endphp

                    <article
                        class="group bg-white border border-gray-200 rounded-2xl overflow-hidden
                               shadow-sm hover:shadow-md hover:-translate-y-0.5
                               transition-all duration-300 flex flex-col">

                        <a href="{{ $href }}" @if ($target) target="{{ $target }}" rel="noopener" @endif
                            class="relative block aspect-[16/9] overflow-hidden bg-gray-900">

                            @if ($publication->thumbnail)
                                <img src="{{ asset('storage/' . $publication->thumbnail) }}" alt="{{ $publication->title }}"
                                    class="relative z-10 w-full h-full object-cover transition-transform duration-300 group-hover:scale-105">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm bg-gray-100">
                                    Tidak ada gambar
                                </div>
                            @endif

                            @if ($type === 'video')
                                <span
                                    class="absolute inset-0 z-20 flex items-center justify-center bg-black/30 group-hover:bg-black/40 transition">
                                    <span
                                        class="w-14 h-14 rounded-full bg-white/90 text-emerald-700 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z" />
                                        </svg>
                                    </span>
                                </span>
                            @endif
                        </a>

                        <div class="p-6 flex flex-col justify-between flex-1">
                            <div>
                                @if ($meta['has_category'] && $publication->category)
                                    <span
                                        class="inline-flex mb-3 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                                        {{ $publication->category->name }}
                                    </span>
                                @endif

                                <h2
                                    class="text-[1.05rem] font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-emerald-700 transition">
                                    <a href="{{ $href }}" @if ($target) target="{{ $target }}"
                                        rel="noopener" @endif>
                                        {{ $publication->title }}
                                    </a>
                                </h2>

                                @if ($meta['has_content'] && $publication->content)
                                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit(html_entity_decode(strip_tags($publication->content)), 140) }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-6 flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $publication->created_at->translatedFormat('d F Y') }}</span>

                                <a href="{{ $href }}" @if ($target) target="{{ $target }}"
                                    rel="noopener" @endif
                                    class="text-emerald-600 font-medium hover:text-emerald-700">
                                    {{ $isMedia ? 'Lihat' : 'Baca' }} →
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach

            </div>

        @endif

        @if ($publications->hasPages())
            <div class="pt-4">
                {{ $publications->onEachSide(1)->links() }}
            </div>
        @endif

    </div>

@endsection
