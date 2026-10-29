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
                    <p class="text-gray-700 leading-relaxed text-justify">
                        {{ $organization->about }}
                    </p>
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

                <div class="grid md:grid-cols-2 gap-8">

                    <div class="bg-white border rounded-2xl p-8 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Visi</h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed line-clamp-6">
                            {!! $organization->vision ?: '<p>Visi organisasi belum diisi.</p>' !!}
                        </div>
                        <a href="{{ route('tentang.visi-misi') }}"
                            class="inline-flex mt-6 text-sm font-medium text-emerald-700 hover:text-emerald-800">
                            Lihat visi dan misi lengkap →
                        </a>
                    </div>

                    <div class="bg-white border rounded-2xl p-8 shadow-sm">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Misi</h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed line-clamp-6">
                            {!! $organization->mission ?: '<p>Misi organisasi belum diisi.</p>' !!}
                        </div>
                        <a href="{{ route('tentang.visi-misi') }}"
                            class="inline-flex mt-6 text-sm font-medium text-emerald-700 hover:text-emerald-800">
                            Lihat visi dan misi lengkap →
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <section class="bg-white">
            <div class="max-w-6xl mx-auto px-6 py-16">

                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">Informasi & Kontak</h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Hubungi {{ $organization->name }} melalui informasi resmi berikut.
                    </p>
                </div>

                <x-contact-cards :organization="$organization" :showSocial="true" :showMap="true" />

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
