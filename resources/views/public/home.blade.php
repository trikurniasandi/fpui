@extends('layouts.public')

@section('title', 'Forum Perpustakaan Umum Indonesia')

@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) merupakan wadah kolaborasi, informasi, dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16 space-y-24">
    
    @if($banner->isNotEmpty())
        <section 
            x-data="{
                active: 0,
                total: {{ $banner->count() }},
                next() { this.active = (this.active + 1) % this.total },
                prev() { this.active = (this.active - 1 + this.total) % this.total }
            }"
            x-init="setInterval(() => next(), 6000)"
            class="relative"
        >
            <div class="relative overflow-hidden rounded-3xl h-[520px] shadow-xl">

                @foreach($banner as $index => $item)
                <div x-show="active === {{ $index }}"
                    x-transition.opacity.duration.700ms
                    class="absolute inset-0">

                    <img src="{{ $item->thumbnail 
                                ? asset('storage/' . $item->thumbnail) 
                                : 'https://picsum.photos/1600/600' }}"
                        class="absolute inset-0 w-full h-full object-cover">

                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/70 to-transparent"></div>

                    <div class="relative z-10 h-full flex items-center px-20">
                        <div class="max-w-2xl text-white space-y-6">

                            <span class="inline-block text-sm font-semibold px-4 py-1.5 rounded-full
                                    {{ $item->type === 'news'
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'bg-emerald-100 text-emerald-700' }}">
                                {{ $item->type === 'news' ? 'Berita' : 'Artikel' }}
                            </span>

                            <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                                {{ Str::limit(html_entity_decode(strip_tags($item->title)), 25) }}
                            </h1>

                            <p class="text-gray-200 text-lg leading-relaxed line-clamp-3">
                                {{ Str::limit(html_entity_decode(strip_tags($item->content)), 200) }}
                            </p>

                            <a href="{{ $item->type === 'news'
                                        ? route('news.show', $item->slug)
                                        : route('article.show', $item->slug) }}"
                               class="inline-flex items-center gap-2 px-6 py-3 font-semibold rounded-xl transition
                                {{ $item->type === 'news'
                                    ? 'bg-blue-600 hover:bg-blue-700 text-white'
                                    : 'bg-emerald-600 hover:bg-emerald-700 text-white' }}">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <button @click="prev"
                    class="absolute z-20 left-6 top-1/2 -translate-y-1/2 
                        bg-white/20 hover:bg-white/40 text-white 
                        w-11 h-11 rounded-full backdrop-blur 
                        flex items-center justify-center">
                    ‹
                </button>

                <button @click="next"
                    class="absolute z-20 right-6 top-1/2 -translate-y-1/2 
                        bg-white/20 hover:bg-white/40 text-white 
                        w-11 h-11 rounded-full backdrop-blur 
                        flex items-center justify-center">
                    ›
                </button>

                <div class="absolute z-20 bottom-6 left-1/2 -translate-x-1/2 flex gap-3">
                    @foreach($banner as $index => $item)
                    <button @click="active = {{ $index }}"
                        :class="active === {{ $index }} 
                                ? 'bg-white w-6' 
                                : 'bg-white/50 w-3'"
                        class="h-3 rounded-full transition-all duration-300">
                    </button>
                    @endforeach
                </div>

            </div>
        </section>
    @else
        <section class="relative overflow-hidden rounded-3xl h-[520px] shadow-xl">
            <img src="https://picsum.photos/1600/600"
                class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/70 to-transparent"></div>

            <div class="relative z-10 h-full flex items-center px-20">
                <div class="max-w-2xl text-white space-y-6">
                    <span class="inline-block text-sm font-semibold 
                                bg-emerald-600 px-4 py-1.5 rounded-full">
                        Selamat Datang
                    </span>

                    <h1 class="text-4xl md:text-5xl font-bold leading-tight">
                        Forum Perpustakaan Umum Indonesia
                    </h1>

                    <p class="text-gray-200 text-lg leading-relaxed">
                        Wadah kolaborasi nasional untuk memperkuat peran perpustakaan umum di Indonesia.
                    </p>

                    <a href="{{ route('public.about') }}"
                        class="inline-flex items-center gap-2 
                            px-6 py-3 bg-emerald-600 font-semibold 
                            rounded-xl hover:bg-emerald-700 transition">
                        Pelajari Lebih Lanjut →
                    </a>
                </div>
            </div>
        </section>
    @endif

    <section>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach([
                ['Jejaring Nasional', 'Menghubungkan perpustakaan umum di seluruh Indonesia untuk berbagi praktik terbaik dan inovasi layanan.'],
                ['Pengembangan SDM', 'Mendukung peningkatan kapasitas pustakawan melalui literasi, diskusi, dan publikasi edukatif.'],
                ['Inklusi Sosial', 'Mendorong perpustakaan sebagai ruang belajar yang inklusif dan memberdayakan masyarakat.'],
            ] as [$title, $desc])
                <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                        {{ $title }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $desc }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

    <section>
        <div class="grid md:grid-cols-2 gap-10 items-center">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">
                    Sekilas FPUI
                </h2>
                <div class="text-gray-700 leading-relaxed text-justify">
                    {{ $organization?->description }}
                </div>
            </div>

            <div class="relative h-64 rounded-3xl overflow-hidden">
                <img src="{{ asset('assets/logo.png') }}"
     class="absolute inset-0 w-full h-full object-contain">

                <div class="absolute inset-0 bg-emerald-600/20"></div>
            </div>
        </div>
    </section>

   <section>
    <h2 class="text-2xl font-semibold text-gray-900 mb-10">
        Peran & Fungsi
    </h2>

    <div class="grid md:grid-cols-2 gap-12 items-start">
        <div class="space-y-8">
            @foreach([
                ['01', 'Koordinasi', 'Menghubungkan perpustakaan umum dan pemangku kepentingan.'],
                ['02', 'Fasilitasi', 'Mendukung pertukaran praktik baik dan inovasi layanan.'],
                ['03', 'Advokasi', 'Mendorong kebijakan dan penguatan peran perpustakaan.'],
            ] as [$no, $title, $desc])
                <div class="flex gap-6 items-start">
                    <div class="w-12 h-12 rounded-full bg-emerald-600 text-white flex items-center justify-center font-semibold">
                        {{ $no }}
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-1">
                            {{ $title }}
                        </h3>
                        <p class="text-gray-600 text-sm leading-relaxed">
                            {{ $desc }}
                        </p>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="bg-gray-50 border border-gray-200 rounded-3xl p-8">
            <div class="grid grid-cols-2 gap-6 text-center">
                <div>
                    <p class="text-3xl font-bold text-emerald-600">30+</p>
                    <p class="text-sm text-gray-600 mt-1">Perpustakaan Terlibat</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">15+</p>
                    <p class="text-sm text-gray-600 mt-1">Kegiatan Nasional</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">10+</p>
                    <p class="text-sm text-gray-600 mt-1">Wilayah Provinsi</p>
                </div>
                <div>
                    <p class="text-3xl font-bold text-emerald-600">100+</p>
                    <p class="text-sm text-gray-600 mt-1">Pustakawan Terlibat</p>
                </div>
            </div>
        </div>
    </div>
    </section>

    <section>
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r
                    from-emerald-600 to-emerald-500 p-10 md:p-14 text-white">
            <div class="max-w-3xl">
                <span class="text-sm font-semibold uppercase tracking-wide opacity-90">
                    Agenda
                </span>

                <h2 class="text-3xl font-semibold mt-3 mb-4">
                    Agenda Nasional & Kolaboratif
                </h2>

                <p class="text-emerald-50 leading-relaxed mb-6">
                    FPUI secara rutin menyelenggarakan forum diskusi, webinar literasi,
                    dan agenda kolaboratif lintas daerah.
                </p>

                <a href="#"
                class="inline-flex items-center gap-2 px-6 py-3
                        bg-white text-emerald-700 font-semibold rounded-xl
                        hover:bg-emerald-50 transition">
                    Lihat Agenda
                    <span>→</span>
                </a>
            </div>
        </div>
    </section>


    @if($publications->isEmpty())
        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-8 text-center text-gray-500">
            Belum ada publikasi yang tersedia.
        </div>
    @else

    <section id="publikasi-terbaru" aria-labelledby="heading-publikasi">
        <div class="flex items-center justify-between mb-6">
            <h2 id="heading-publikasi" class="text-2xl font-semibold text-gray-900">
                Publikasi Terbaru
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($publications as $pub)
                <article
                    class="group bg-white rounded-2xl border border-gray-200 p-6
                        shadow-sm hover:shadow-lg hover:-translate-y-1
                        transition-all duration-300 flex flex-col">

                    <span class="inline-block items-center gap-1 mb-3 text-xs font-semibold px-3 py-1 rounded-full
                        {{ $pub->type === 'news'
                            ? 'bg-blue-50 text-blue-700'
                            : 'bg-emerald-50 text-emerald-700' }}">
                        {{ $pub->type === 'news' ? 'Berita' : 'Artikel' }}
                    </span>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2
                            group-hover:text-emerald-700 transition-colors">
                        <a href="{{ $pub->type === 'news'
                                    ? route('news.show', $pub->slug)
                                    : route('article.show', $pub->slug) }}">
                            {{ $pub->title }}
                        </a>
                    </h3>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($pub->content), 120) }}
                    </p>

                    <div class="mt-auto pt-4 flex items-center justify-between text-xs text-gray-500 border-t border-gray-100">
                        <span>{{ $pub->created_at->translatedFormat('d F Y') }}</span>

                        <a href="{{ $pub->type === 'news'
                                    ? route('news.show', $pub->slug)
                                    : route('article.show', $pub->slug) }}"
                        class="inline-flex items-center gap-1 font-medium text-emerald-600 hover:text-emerald-700">
                            Baca
                            <span class="transition group-hover:translate-x-1">→</span>
                        </a>
                    </div>

                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $publications->onEachSide(1)->fragment('publikasi-terbaru')->links() }} 
        </div>
    </section>
    @endif
    
    <section>
        <div class="bg-gray-900 rounded-3xl p-10 md:p-14 text-white flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold mb-4">
                    Tentang FPUI
                </h2>
                <p class="text-gray-300 leading-relaxed text-justify">
                {{ $organization?->about }}    
                </p>
            </div>

            <a href="{{ route('public.about') }}"
               class="px-7 py-3 bg-emerald-600 font-semibold rounded-xl hover:bg-emerald-700 transition">
                Tentang Kami
            </a>
        </div>
    </section>
</div>
@endsection