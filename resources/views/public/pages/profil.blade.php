@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    @if ($organization)

        <section class="bg-white">
            <div class="max-w-4xl mx-auto px-6 py-16">

                <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                    {{ $organization->name }}
                </h2>

                @if ($organization->about)
                    <x-safe-html :html="$organization->about" class="space-y-4 text-gray-700 leading-relaxed text-justify" />
                @endif

                @if ($organization->description)
                    <p class="mt-4 text-gray-600 leading-relaxed text-justify">
                        {{ $organization->description }}
                    </p>
                @endif

                @if (!$organization->about && !$organization->description)
                    <x-empty-state title="Deskripsi profil belum tersedia"
                        message="Profil organisasi dapat dilengkapi melalui menu Pengaturan → Profil Organisasi pada dashboard admin." />
                @endif

            </div>
        </section>

        <section class="bg-gray-50 border-y">
            <div class="max-w-6xl mx-auto px-6 py-16">

                <div class="max-w-2xl mx-auto text-center mb-10">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Selengkapnya tentang FPUI</h2>
                    <p class="text-gray-600 leading-relaxed">
                        Telusuri informasi organisasi dan kanal komunikasi melalui halaman berikut.
                    </p>
                </div>

                <div class="grid sm:grid-cols-2 gap-6">

                    @foreach ([
                        ['title' => 'Visi dan Misi', 'text' => 'Arah dan komitmen organisasi.', 'route' => 'tentang.visi-misi'],
                        ['title' => 'Sejarah', 'text' => 'Perjalanan dan tonggak berdirinya FPUI.', 'route' => 'tentang.sejarah'],
                        ['title' => 'Struktur Organisasi', 'text' => 'Susunan kepengurusan dan tata kelola.', 'route' => 'tentang.struktur-organisasi'],
                        ['title' => 'Hubungi Kami', 'text' => 'Kanal komunikasi dan sekretariat resmi.', 'route' => 'kontak.hubungi-kami'],
                    ] as $link)
                        <a href="{{ route($link['route']) }}"
                            class="group flex items-start justify-between gap-4 bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:border-emerald-200 hover:shadow-md transition">
                            <span>
                                <span class="block font-semibold text-gray-900 group-hover:text-emerald-700 transition">
                                    {{ $link['title'] }}
                                </span>
                                <span class="block text-sm text-gray-600 mt-1 leading-relaxed">
                                    {{ $link['text'] }}
                                </span>
                            </span>
                            <span class="text-emerald-600 group-hover:translate-x-1 transition" aria-hidden="true">→</span>
                        </a>
                    @endforeach

                </div>

            </div>
        </section>

    @else

        <div class="max-w-4xl mx-auto px-6 py-20">
            <x-empty-state title="Data organisasi belum tersedia"
                message="Profil organisasi belum diisi. Silakan lengkapi melalui dashboard admin." />
        </div>

    @endif

    <section class="bg-emerald-600 text-white">
        <div class="max-w-4xl mx-auto px-6 py-20 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Gabung Bersama Kami</h2>
            <p class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed">
                FPUI terbuka untuk seluruh pengelola perpustakaan umum yang ingin
                berkolaborasi dan berkontribusi dalam penguatan literasi nasional.
            </p>
            <a href="{{ route('organisasi.keanggotaan') }}"
                class="inline-flex px-8 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition shadow-sm">
                Informasi Keanggotaan
            </a>
        </div>
    </section>

@endsection
