@extends('layouts.public')

@section('title', $publication->title)
@section('meta_description', Str::limit(strip_tags($publication->content ?: $publication->title), 160))

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

        <x-breadcrumb :items="[
            ['label' => 'Publikasi'],
            ['label' => $meta['label'], 'route' => $meta['route_name'] . '.index'],
            ['label' => Str::limit($publication->title, 60)],
        ]" />

        <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            @if ($publication->thumbnail)
                <div class="relative aspect-[16/9] overflow-hidden bg-gray-900">
                    <img src="{{ asset('storage/' . $publication->thumbnail) }}" alt="{{ $publication->title }}"
                        class="relative z-10 mx-auto h-full max-w-full object-contain">
                </div>
            @endif

            <div class="p-6 sm:p-8">

                <header class="mb-6">
                    @if ($meta['has_category'] && $publication->category)
                        <span
                            class="inline-flex mb-3 rounded-full bg-emerald-50 px-3 py-1 text-xs font-semibold text-emerald-700">
                            {{ $publication->category->name }}
                        </span>
                    @endif

                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-3">
                        {{ $publication->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-gray-500">
                        <span>{{ $publication->created_at->translatedFormat('l, d F Y') }}</span>
                        <span>•</span>
                        <span>{{ $publication->created_at->format('H:i') }} WIB</span>
                        <span>•</span>
                        <span>{{ $publication->author->name ?? '-' }}</span>
                    </div>
                </header>

                @if ($publication->content)
                    <div class="prose max-w-full text-gray-700 text-justify">
                        {!! $publication->content !!}
                    </div>
                @endif

                @if ($publication->attachment)
                    <div class="mt-10 border-t pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">
                            Lampiran
                        </h4>

                        <a href="{{ asset('storage/' . $publication->attachment) }}" target="_blank" rel="noopener"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-200
                                   text-emerald-700 hover:bg-emerald-50 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0 0l-4-4m4 4l4-4M12 4v8" />
                            </svg>
                            Unduh lampiran
                        </a>
                    </div>
                @endif

                <footer class="mt-10 flex justify-between items-center text-sm text-gray-500">
                    <a href="{{ route($meta['route_name'] . '.index') }}"
                        class="text-emerald-600 hover:text-emerald-700 font-medium">
                        ← Kembali ke daftar {{ Str::lower($meta['label']) }}
                    </a>
                </footer>

            </div>

        </article>

    </div>

@endsection
