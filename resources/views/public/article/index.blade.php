@extends('layouts.public')

@section('title', 'Artikel Literasi')

@section('meta_description', 'Kumpulan artikel literasi, edukasi, dan pengembangan perpustakaan umum di Indonesia.')

@section('content')
    <div class="max-w-7xl mx-auto px-6 py-14 space-y-12">

        <section>
            <div class="bg-white border border-gray-200 rounded-3xl p-10 shadow-sm">
                <h1 class="text-3xl font-bold text-gray-900 mb-3">
                    Artikel Literasi
                </h1>
                <p class="text-gray-600 max-w-2xl">
                    Artikel pilihan seputar literasi, pengelolaan perpustakaan umum,
                    pengembangan SDM, dan praktik baik layanan informasi.
                </p>
            </div>
        </section>

        <section>
            @if($articles->isEmpty())
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-8 text-center text-gray-500">
                    Belum ada artikel yang dipublikasikan.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($articles as $article)
                        <article class="group bg-white border border-gray-200 rounded-2xl overflow-hidden
                           shadow-sm hover:shadow-md transition flex flex-col">

                            <a href="{{ route('article.show', $article->slug) }}"
                                class="block aspect-[16/9] overflow-hidden bg-gray-100">
                                @if ($article->thumbnail)
                                    <img src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}" class="w-full h-full object-cover object-top group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center
                                        text-gray-400 text-sm">
                                        Tidak ada gambar
                                    </div>
                                @endif
                            </a>

                            <div class="p-6 flex flex-col justify-between flex-1">
                                <div>
                                    <span class="inline-block mb-3 text-xs font-semibold px-3 py-1 rounded-full
                            bg-emerald-100 text-emerald-700">
                                        Artikel
                                    </span>

                                    <h2 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2
                                   group-hover:text-emerald-700 transition">
                                        <a href="{{ route('article.show', $article->slug) }}">
                                            {{ $article->title }}
                                        </a>
                                    </h2>

                                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 140) }}
                                    </p>
                                </div>

                                <div class="mt-6 flex items-center justify-between text-xs text-gray-500">
                                    <span>
                                        {{ $article->created_at->format('d M Y') }}
                                    </span>

                                    <a href="{{ route('article.show', $article->slug) }}"
                                        class="font-medium text-emerald-600 hover:text-emerald-700">
                                        Baca →
                                    </a>
                                </div>
                            </div>
                        </article>

                    @endforeach
                </div>
            @endif
        </section>

        <section>
            <div class="pt-6">
                {{ $articles->links() }}
            </div>
        </section>

    </div>
@endsection