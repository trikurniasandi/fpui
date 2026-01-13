@extends('layouts.public')

@section('title', 'Berita Perpustakaan')

@section('meta_description', 'Kumpulan berita terbaru terkait perpustakaan umum di Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10 space-y-8">

    <h1 class="text-3xl font-bold text-gray-900 mb-6">
        Berita Terbaru
    </h1>

    @if($news->isEmpty())
        <div class="rounded-xl bg-gray-50 border border-gray-200 p-6 text-center text-gray-500">
            Belum ada berita tersedia.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($news as $item)
                <article class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
                    <span class="inline-block mb-3 text-xs font-semibold px-3 py-1 rounded-full bg-blue-100 text-blue-700">
                        Berita
                    </span>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ route('news.show', $item->slug) }}" class="hover:text-emerald-700">
                            {{ $item->title }}
                        </a>
                    </h3>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($item->content), 120) }}
                    </p>

                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ $item->created_at->format('d M Y') }}</span>
                        <a href="{{ route('news.show', $item->slug) }}" class="font-medium text-emerald-600">Baca →</a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $news->links() }}
        </div>
    @endif

</div>
@endsection