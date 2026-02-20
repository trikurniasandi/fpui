@extends('layouts.public')

@section('title', 'Berita')

@section('meta_description', 'Berita terkini seputar literasi, perpustakaan, dan layanan informasi publik.')

@section('content')
    <section class="bg-gradient-to-b from-emerald-50 to-white">
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Berita
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto">
                  Informasi dan berita terbaru terkait kegiatan, program,
                    kebijakan, serta perkembangan di bidang perpustakaan,
                    kearsipan, dan literasi masyarakat.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-6 py-14 space-y-12">
        <section>
            @if($news->isEmpty())
                <div class="rounded-2xl bg-gray-50 border border-gray-200 p-8 text-center text-gray-500">
                    Belum ada berita yang dipublikasikan.
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                        <article class="group bg-white border border-gray-200 rounded-2xl overflow-hidden
                                               shadow-sm hover:shadow-md hover:-translate-y-0.5
                                               transition-all duration-300 flex flex-col">

                            <a href="{{ route('news.show', $item->slug) }}"
                                class="relative block aspect-[16/9] overflow-hidden bg-gray-900">

                                @if ($item->thumbnail)
                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt=""
                                        class="absolute inset-0 w-full h-full object-cover scale-110 blur-lg opacity-40"
                                        aria-hidden="true">

                                    <div class="absolute inset-0 bg-black/30"></div>

                                    <img src="{{ asset('storage/' . $item->thumbnail) }}" alt="{{ $item->title }}" class="relative z-10 w-full h-full object-contain
                                                                transition-transform duration-300 group-hover:scale-105">
                                @else
                                    <div class="w-full h-full flex items-center justify-center
                                                                text-gray-400 text-sm bg-gray-100">
                                        Tidak ada gambar
                                    </div>
                                @endif
                            </a>

                            <div class="p-6 flex flex-col justify-between flex-1">
                                <div>
                                    <span class="inline-flex mb-3 rounded-full
                                                           bg-blue-50 px-3 py-1
                                                           text-xs font-semibold text-blue-700">
                                        {{ $item->category?->name ?? 'Berita' }}
                                    </span>

                                    <h2 class="text-[1.05rem] font-semibold text-gray-900 mb-2
                                                           line-clamp-2
                                                           group-hover:text-blue-700 transition">

                                        <a href="{{ route('news.show', $item->slug) }}">
                                            {{ $item->title }}
                                        </a>
                                    </h2>

                                    <p class="text-sm text-gray-600 leading-relaxed line-clamp-3">
                                        {{ Str::limit(html_entity_decode(strip_tags($item->content)), 140) }}
                                    </p>
                                </div>

                                <div class="mt-6 flex items-center justify-between text-sm text-gray-500">
                                    <span>
                                        {{ $item->created_at->translatedFormat('d F Y') }}
                                    </span>

                                    <a href="{{ route('news.show', $item->slug) }}"
                                        class="text-blue-600 font-medium hover:text-blue-700">
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
            <div class="pt-8">
                {{ $news->onEachSide(1)->links() }}
            </div>
        </section>

    </div>
@endsection