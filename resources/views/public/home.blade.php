@extends('layouts.public')

@section('title', 'Forum Perpustakaan Umum Indonesia')

@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) merupakan wadah kolaborasi, informasi, dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-14 space-y-16">

    <section>
        <div class="relative overflow-hidden rounded-3xl">
            <img src="https://picsum.photos/1600/600"
                 class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 via-gray-900/60 to-transparent"></div>

            <div class="relative z-10 px-10 py-16 max-w-3xl text-white">
                <span class="inline-block mb-4 text-sm font-semibold bg-emerald-600/90 px-4 py-1.5 rounded-full">
                    Agenda Nasional
                </span>

                <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-5">
                    Forum Perpustakaan Umum Indonesia
                </h1>

                <p class="text-gray-200 text-lg mb-8">
                    Wadah kolaborasi nasional untuk memperkuat peran perpustakaan umum
                    sebagai pusat literasi, informasi, dan pemberdayaan masyarakat.
                </p>

                <div class="flex gap-4">
                    <a href="{{ route('article.index') }}"
                       class="px-6 py-3 bg-emerald-600 font-semibold rounded-xl hover:bg-emerald-700 transition">
                        Artikel Literasi
                    </a>
                    <a href="{{ route('news.index') }}"
                       class="px-6 py-3 bg-white/90 text-gray-900 font-semibold rounded-xl hover:bg-white transition">
                        Berita Terkini
                    </a>
                </div>
            </div>
        </div>
    </section>

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
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-semibold text-gray-900">
                Publikasi Terbaru
            </h2>
            <a href="{{ route('article.index') }}"
               class="text-sm font-medium text-emerald-600 hover:text-emerald-700">
                Lihat semua →
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
           @foreach($publications as $pub)
                <publication class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm hover:shadow-md transition">
                    <span class="inline-block mb-3 text-xs font-semibold px-3 py-1 rounded-full
                        {{ $pub->type === 'news' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ ucfirst($pub->type) }}
                    </span>

                    <h3 class="text-lg font-semibold text-gray-900 mb-2 line-clamp-2">
                        <a href="{{ $pub->type === 'news' 
                                    ? route('news.show', $pub->slug) 
                                    : route('article.show', $pub->slug) }}" 
                        class="hover:text-emerald-700">
                            {{ $pub->title }}
                        </a>
                    </h3>

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3">
                        {{ Str::limit(strip_tags($pub->content), 120) }}
                    </p>

                    <div class="flex justify-between text-xs text-gray-500">
                        <span>{{ $pub->created_at->format('d M Y') }}</span>

                        <a href="{{ $pub->type === 'news' 
                                    ? route('news.show', $pub->slug) 
                                    : route('article.show', $pub->slug) }}"
                            class="font-medium text-emerald-600 hover:text-emerald-700">
                            Baca →
                        </a>
                    </div>

                </publication>
            @endforeach

        </div>
    </section>

    <section>
        <div class="bg-gray-900 rounded-3xl p-10 md:p-14 text-white flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl">
                <h2 class="text-3xl font-semibold mb-4">
                    Tentang FPUI
                </h2>
                <p class="text-gray-300 leading-relaxed">
                    FPUI berperan sebagai ruang kolaborasi nasional untuk memperkuat peran
                    perpustakaan umum dalam pembangunan literasi dan masyarakat berbasis pengetahuan.
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