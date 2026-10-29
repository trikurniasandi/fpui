@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    <div class="max-w-6xl mx-auto px-6 py-14 space-y-14">

        @switch($content['mode'] ?? 'sekretariat')

            @case('hubungi-kami')
                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 text-center mb-8">Kanal Informasi</h2>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach ($content['channels'] ?? [] as $channel)
                            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm">
                                <h3 class="font-semibold text-gray-900 mb-2">{{ $channel['title'] }}</h3>
                                <p class="text-sm text-gray-600 leading-relaxed">{{ $channel['text'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </section>

                <section>
                    <h2 class="text-2xl font-semibold text-gray-900 text-center mb-8">Kontak Resmi</h2>

                    <x-contact-cards :organization="$organization" />

                    <div class="mt-10 rounded-2xl bg-emerald-50 border border-emerald-100 p-6 text-center">
                        <p class="text-sm text-emerald-800 leading-relaxed">
                            Jam layanan: {{ $content['hours'] ?? 'Senin – Jumat, 08.00 – 16.00 WIB' }}.
                            Kami akan merespons pesan pada hari kerja.
                        </p>
                    </div>
                </section>
                @break

            @case('media-sosial')
                <section class="max-w-3xl mx-auto text-center">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-3">Kanal Resmi FPUI</h2>
                    <p class="text-gray-600 mb-10">{{ $content['note'] ?? '' }}</p>

                    <x-contact-cards :organization="$organization" :showSocial="true" />
                </section>
                @break

            @default
                <section>
                    <div class="max-w-4xl mx-auto text-center mb-10">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-3">Kontak Sekretariat</h2>
                        <p class="text-gray-600 leading-relaxed">
                            Korespondensi resmi, permohonan informasi, dan kunjungan dapat disampaikan
                            melalui kanal berikut.
                        </p>
                    </div>

                    <x-contact-cards :organization="$organization" :showMap="true" />

                    <div class="mt-10 grid gap-4 sm:grid-cols-2 max-w-3xl mx-auto">
                        <div class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
                            <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Jam Layanan</div>
                            <div class="mt-2 text-gray-800">
                                {{ $content['hours'] ?? 'Senin – Jumat, 08.00 – 16.00 WIB' }}
                            </div>
                        </div>

                        <div class="rounded-2xl border border-gray-100 bg-white p-6 text-center shadow-sm">
                            <div class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Catatan Kunjungan</div>
                            <div class="mt-2 text-sm text-gray-600 leading-relaxed">
                                {{ $content['note'] ?? 'Kunjungan dimohon membuat janji terlebih dahulu.' }}
                            </div>
                        </div>
                    </div>
                </section>
        @endswitch

        <div class="flex flex-wrap justify-center gap-3 pt-2">
            <a href="{{ route('kontak.hubungi-kami') }}"
                class="inline-flex px-5 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                Hubungi Kami
            </a>
            <a href="{{ route('kontak.kerja-sama') }}"
                class="inline-flex px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Ajukan Kerja Sama
            </a>
        </div>

    </div>

@endsection
