@extends('layouts.public')

@section('title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->content), 160))

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 space-y-10">

    <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        @if ($article->thumbnail)
            <div class="aspect-[16/9] bg-gray-100">
                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                     alt="{{ $article->title }}"
                     class="w-full h-full object-cover object-top">
            </div>
        @endif

        <div class="p-8">
            <header class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    {{ $article->title }}
                </h1>
                <div class="text-sm text-gray-500">
                    {{ $article->created_at->format('d M Y') }}
                    • {{ $article->author->name ?? 'Admin' }}
                </div>
            </header>

            <div class="prose max-w-full text-gray-700">
                {!! $article->content !!}
            </div>

            @if ($article->attachment)
                <div class="mt-10 border-t pt-6">
                    <h4 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">
                        Lampiran
                    </h4>

                    <a href="{{ asset('storage/' . $article->attachment) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 px-4 py-2
                              rounded-lg border border-gray-200
                              text-sm font-medium text-emerald-700
                              hover:bg-emerald-50 transition">

                        📎 Unduh Lampiran
                    </a>
                </div>
            @endif

            <footer class="mt-10 flex justify-between items-center text-sm text-gray-500">
                <a href="{{ route('article.index') }}"
                   class="text-emerald-600 hover:text-emerald-700 font-medium">
                    Kembali ke daftar artikel →
                </a>
            </footer>
        </div>

    </article>

</div>
@endsection