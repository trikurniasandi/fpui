@extends('layouts.public')

@section('title', $article->title)
@section('meta_description', Str::limit(strip_tags($article->content), 160))

@section('content')
<div class="max-w-7xl mx-auto px-6 py-12 space-y-10">

    <article class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
                {{ $article->title }}
            </h1>
            <div class="text-sm text-gray-500">
                {{ $article->created_at->format('d M Y') }} • {{ $article->user->name ?? 'Admin' }}
            </div>
        </header>

        <div class="prose max-w-full text-gray-700">
            {!! $article->content !!}
        </div>

        <footer class="mt-8 flex justify-between items-center text-sm text-gray-500">
            <span>Tipe: {{ ucfirst($article->type) }}</span>
            <a href="{{ route('article.index') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                Kembali ke daftar artikel →
            </a>
        </footer>
    </article>

</div>
@endsection
