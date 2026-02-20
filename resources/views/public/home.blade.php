@extends('layouts.public')

@section('title', 'Forum Perpustakaan Umum Indonesia')

@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) merupakan wadah kolaborasi, informasi, dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')

<div class="space-y-28">

    <section class="max-w-7xl mx-auto px-6 pt-16">
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
            <div class="relative overflow-hidden rounded-3xl h-[520px] shadow-2xl">

                @foreach($banner as $index => $item)
                <div x-show="active === {{ $index }}"
                    x-transition.opacity.duration.700ms
                    class="absolute inset-0">

                    <img src="{{ $item->thumbnail 
                                ? asset('storage/' . $item->thumbnail) 
                                : asset('assets/images/logo.png') }}"
                        class="absolute inset-0 w-full h-full object-cover">

                    <div class="absolute inset-0 bg-gradient-to-r from-gray-900/95 via-gray-900/70 to-transparent"></div>

                    <div class="relative z-10 h-full flex items-center px-8 md:px-20">
                        <div 
                            x-data="{ show: false }"
                            x-init="setTimeout(() => show = true, 200)"
                            :class="show 
                                ? 'opacity-100 translate-y-0' 
                                : 'opacity-0 translate-y-6'"
                            class="max-w-2xl text-white space-y-6 transition-all duration-700 ease-out"
                        >

                            <span class="inline-block text-xs font-semibold tracking-wide uppercase px-4 py-1.5 rounded-full
                                {{ $item->type === 'news'
                                ? 'bg-blue-500/20 text-blue-200'
                                : 'bg-emerald-500/20 text-emerald-200' }}">
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
                                    ? 'bg-blue-600 hover:bg-blue-700'
                                    : 'bg-emerald-600 hover:bg-emerald-700' }}">
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
            <img src={{ asset('assets/images/logo.png') }}
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
    </section>

    <section class="max-w-7xl mx-auto px-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach([
                ['Jejaring Nasional', 'Menghubungkan perpustakaan umum di seluruh Indonesia untuk berbagi praktik terbaik dan inovasi layanan.'],
                ['Pengembangan SDM', 'Mendukung peningkatan kapasitas pustakawan melalui literasi, diskusi, dan publikasi edukatif.'],
                ['Inklusi Sosial', 'Mendorong perpustakaan sebagai ruang belajar yang inklusif dan memberdayakan masyarakat.'],
            ] as [$title, $desc])
           <div 
    x-data="{ show: false }"
    x-intersect.once="setTimeout(() => show = true, 100)"
    :class="show 
        ? 'opacity-100 translate-y-0' 
        : 'opacity-0 translate-y-8'"
    class="bg-white rounded-3xl border border-gray-100 p-8 shadow-sm 
           hover:shadow-xl hover:-translate-y-2
           transition-all duration-700 ease-out"
>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">
                        {{ $title }}
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $desc }}
                    </p>
                </div>
            @endforeach
        </div>
    </section>

 <section class="bg-gradient-to-b from-emerald-50 to-white">
    <div class="max-w-7xl mx-auto px-6 py-20">
        <div class="grid md:grid-cols-2 gap-16 items-center">

            <div 
                x-data="{ show: false }"
                x-intersect.once="setTimeout(() => show = true, 100)"
                :class="show 
                    ? 'opacity-100 translate-x-0' 
                    : 'opacity-0 -translate-x-10'"
                class="transition-all duration-700 ease-out"
            >
                <h2 class="text-3xl font-bold mb-6">
                    Sekilas FPUI
                </h2>
                <div class="text-gray-700 leading-relaxed text-justify">
                    {{ $organization?->description }}
                </div>
            </div>

            <div 
                x-data="{ show: false }"
                x-intersect.once="setTimeout(() => show = true, 300)"
                :class="show 
                    ? 'opacity-100 translate-x-0' 
                    : 'opacity-0 translate-x-10'"
                class="relative rounded-3xl p-12 flex items-center justify-center transition-all duration-700 ease-out"
            >
                <img src="{{ asset('assets/images/logo.png') }}"
                    class="w-64 object-contain">
            </div>

        </div>
    </div>
</section>
    
   <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10 text-center">

                @foreach([
                    [30, '+', 'Perpustakaan Terlibat'],
                    [15, '+', 'Kegiatan Nasional'],
                    [10, '+', 'Wilayah Provinsi'],
                    [100, '+', 'Pustakawan Terlibat'],
                ] as [$value, $suffix, $label])

                <div 
                    x-data="counter({{ $value }})"
                    x-intersect.once="start()"
                    class="space-y-2"
                >
                    <p class="text-4xl font-bold text-emerald-600">
                        <span x-text="display"></span>{{ $suffix }}
                    </p>
                    <p class="text-sm text-gray-600">
                        {{ $label }}
                    </p>
                </div>

                @endforeach

            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-6">
        <div class="flex items-center justify-between mb-10">
            <h2 class="text-3xl font-bold text-gray-900">
                Publikasi Terbaru
            </h2>
        </div>

        @if($publications->isEmpty())
            <div class="rounded-3xl border border-gray-200 bg-gray-50 p-10 text-center text-gray-500">
                Belum ada publikasi yang tersedia.
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($publications as $pub)
                   <article 
                    x-data="{ show: false }"
                    x-intersect.once="setTimeout(() => show = true, 150)"
                    :class="show 
                        ? 'opacity-100 translate-y-0' 
                        : 'opacity-0 translate-y-10'"
                    class="group bg-white rounded-3xl border border-gray-100 p-8
                        shadow-sm hover:shadow-xl hover:-translate-y-2
                        transition-all duration-700 ease-out flex flex-col">

                        <span class="text-xs font-semibold mb-4
                            {{ $pub->type === 'news'
                                ? 'text-blue-600'
                                : 'text-emerald-600' }}">
                            {{ strtoupper($pub->type) }}
                        </span>

                        <h3 class="text-lg font-semibold text-gray-900 mb-3 line-clamp-2">
                            <a href="{{ $pub->type === 'news'
                                        ? route('news.show', $pub->slug)
                                        : route('article.show', $pub->slug) }}"
                               class="hover:text-emerald-600 transition">
                                {{ $pub->title }}
                            </a>
                        </h3>

                        <p class="text-sm text-gray-600 mb-6 line-clamp-3">
                            {{ Str::limit(html_entity_decode(strip_tags($pub->content)), 120) }}
                        </p>

                        <div class="mt-auto text-xs text-gray-500">
                            {{ $pub->created_at->translatedFormat('d F Y') }}
                        </div>

                    </article>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $publications->onEachSide(1)->links() }}
            </div>
        @endif
    </section>

   <section class="bg-gradient-to-b from-white to-emerald-50 py-20">
        <div class="max-w-7xl mx-auto px-6">
            <div 
                x-data="{ show: false }"
                x-intersect.once="setTimeout(() => show = true, 200)"
                :class="show 
                    ? 'opacity-100 scale-100' 
                    : 'opacity-0 scale-95'"
                class="bg-gradient-to-r from-emerald-600 to-emerald-500 
                    rounded-3xl p-14 text-white text-center
                    transition-all duration-900 ease-out"
            >
                <h2 class="text-3xl font-bold mb-6">
                    Bersama Memperkuat Literasi Indonesia
                </h2>
                <p class="max-w-2xl mx-auto mb-8 text-emerald-50">
                    FPUI terbuka untuk kolaborasi dan partisipasi aktif dalam pengembangan
                    perpustakaan umum yang inklusif dan inovatif.
                </p>

                <a href="{{ route('public.about') }}"
                class="inline-flex px-8 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition">
                    Tentang Kami
                </a>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('counter', (target) => ({
        target: target,
        display: 0,
        duration: 1500,
        start() {
            let startTime = null;

            const animate = (timestamp) => {
                if (!startTime) startTime = timestamp;
                const progress = timestamp - startTime;
                const percentage = Math.min(progress / this.duration, 1);
                this.display = Math.floor(percentage * this.target);

                if (progress < this.duration) {
                    requestAnimationFrame(animate);
                } else {
                    this.display = this.target;
                }
            };

            requestAnimationFrame(animate);
        }
    }))
})
</script>
@endpush