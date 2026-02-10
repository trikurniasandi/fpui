@extends('layouts.public')

@section('title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->content), 160))

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-12 space-y-10">

        <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

            @if ($article->thumbnail)
                <div class="relative aspect-[16/9] overflow-hidden bg-gray-900">

                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt=""
                        class="absolute inset-0 w-full h-full object-cover scale-110 blur-xl opacity-40" aria-hidden="true">

                    <div class="absolute inset-0 bg-black/30"></div>

                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}"
                        class="relative z-10 mx-auto h-full max-w-full object-contain">

                </div>
            @else
                <div class="relative aspect-[16/9] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-200
                        flex items-center justify-center">

                    <div class="text-center px-6">
                        <div class="text-gray-400 text-sm font-medium">
                            Tidak ada gambar
                        </div>
                        <div class="text-gray-400 text-xs mt-1">
                            Artikel Literasi
                        </div>
                    </div>
                </div>
            @endif


            <div class="p-8">
                <header class="mb-6">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">
                        {{ $article->title }}
                    </h1>
                    <div class="text-sm text-gray-500">
                        {{ $article->created_at->translatedFormat('l, d F Y') }} Pukul
                        {{ $article->created_at->format('H:i:s') }}
                        • {{ $article->author->name ?? ' - ' }}
                    </div>
                </header>

                <div class="prose max-w-full text-gray-700">
                    {!! $article->content !!}
                </div>

                <div class="mt-10 border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">
                        Kategori
                    </h4>

                    <span class="inline-flex items-center
                                             rounded-full bg-emerald-50
                                             px-4 py-1.5
                                             text-sm font-medium text-emerald-700">
                        {{ $article->category->name }}
                    </span>
                </div>

                @if ($article->attachment)
                    <div class="mt-10 border-t pt-6">
                        <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">
                            Lampiran
                        </h4>

                        <a href="{{ asset('storage/' . $article->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2
                                            rounded-lg border border-gray-200
                                            text-sm font-medium text-emerald-700
                                            hover:bg-emerald-50 transition">

                            📎 Unduh Lampiran
                        </a>
                    </div>
                @endif

                <footer class="mt-10 flex justify-between items-center text-sm text-gray-500">
                    <a href="{{ route('article.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                        Kembali ke daftar artikel →
                    </a>
                </footer>
            </div>

        </article>

    </div>
@endsection