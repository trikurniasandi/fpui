@extends('layouts.public')

@section('title', 'Galeri Foto')
@section('meta_description', 'Galeri foto kegiatan Forum Perpustakaan Umum Indonesia.')

@section('content')

    <x-page-hero title="Galeri Foto"
        subtitle="Dokumentasi kegiatan dan momen penting Forum Perpustakaan Umum Indonesia."
        eyebrow="Publikasi" :breadcrumb="[['label' => 'Publikasi'], ['label' => 'Galeri Foto']]" />

    <div class="max-w-7xl mx-auto px-6 py-14" x-data="{
        open: false,
        src: '',
        title: '',
        show(src, title) {
            this.src = src;
            this.title = title;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        }
    }" @keydown.escape.window="close()">

        @if ($photos->isEmpty())

            <x-empty-state title="Belum ada foto"
                message="Dokumentasi foto kegiatan akan ditampilkan di sini setelah dipublikasikan." />

        @else

            <div class="columns-1 sm:columns-2 lg:columns-3 gap-5 [&>*]:mb-5">
                @foreach ($photos as $photo)
                    <button type="button"
                        @click="show('{{ asset('storage/' . $photo->image) }}', '{{ addslashes($photo->title) }}')"
                        class="block w-full text-left group break-inside-avoid rounded-2xl overflow-hidden border border-gray-100 bg-white shadow-sm hover:shadow-lg transition">

                        <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}"
                            class="w-full h-auto object-cover group-hover:scale-[1.02] transition duration-300" loading="lazy">

                        <div class="px-5 py-4">
                            <div class="font-medium text-gray-900">{{ $photo->title }}</div>
                            @if ($photo->taken_at)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $photo->taken_at->translatedFormat('d F Y') }}
                                </div>
                            @endif
                        </div>
                    </button>
                @endforeach
            </div>

        @endif

        @if ($photos->hasPages())
            <div class="pt-8">
                {{ $photos->onEachSide(1)->links() }}
            </div>
        @endif

        {{-- Lightbox --}}
        <div x-cloak x-show="open" x-transition.opacity
            class="fixed inset-0 z-[60] bg-black/85 flex items-center justify-center p-4" @click.self="close()">

            <button type="button" @click="close()"
                class="absolute top-5 right-5 text-white/80 hover:text-white" aria-label="Tutup">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <figure class="max-w-5xl w-full text-center">
                <img :src="src" :alt="title" class="max-h-[80vh] w-auto mx-auto rounded-lg shadow-2xl">
                <figcaption class="mt-4 text-sm text-white/80" x-text="title"></figcaption>
            </figure>
        </div>

    </div>

@endsection
