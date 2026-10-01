@extends('layouts.public')

@section('title', 'Program FPUI 2025-2028')
@section('meta_description', 'Enam program strategis Forum Perpustakaan Umum Indonesia (FPUI) dalam periode 2025-2028 untuk memperkuat peran perpustakaan umum di seluruh Indonesia.')

@section('content')

    @php
        $programs = [
            [
                'number' => '01',
                'title' => 'Organisasi dan Keanggotaan',
                'description' => 'Penguatan tata kelola dan struktur kepengurusan FPUI, serta pengelolaan keanggotaan yang tertib dan transparan bagi seluruh perpustakaan umum di Indonesia.',
            ],
            [
                'number' => '02',
                'title' => 'Publikasi dan Dokumentasi',
                'description' => 'Penyiapan publikasi dan dokumentasi kegiatan FPUI dalam format cetak maupun digital sebagai sumber rujukan dan jejak aktivitas organisasi.',
            ],
            [
                'number' => '03',
                'title' => 'Kerjasama Antar Lembaga',
                'description' => 'Membangun jejaring kolaborasi dengan pemerintah daerah, perguruan tinggi, lembaga profesi, dan komunitas literasi untuk bersama memperkuat kapasitas perpustakaan umum.',
            ],
            [
                'number' => '04',
                'title' => 'Usaha dan Dana',
                'description' => 'Upaya penguatan sumber daya melalui skema usaha yang berkelanjutan, sponsorship, kemitraan, serta pengelolaan dana yang transparan bagi program FPUI.',
            ],
            [
                'number' => '05',
                'title' => 'Pendidikan dan Pelatihan',
                'description' => 'Menyelenggarakan pendidikan, pelatihan, dan transfer pengetahuan bagi pengelola perpustakaan umum agar memiliki kompetensi yang sesuai tuntutan zaman.',
            ],
            [
                'number' => '06',
                'title' => 'Sertifikasi Profesi Pustakawan',
                'description' => 'Mendukung peningkatan kompetensi dan pengakuan profesi pustakawan melalui skema sertifikasi dan pengakuan berbasis pengalaman bagi tenaga pustakawan.',
            ],
        ];
    @endphp

    <section class="bg-gradient-to-b from-emerald-50 to-white">
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">

            <span
                class="inline-block text-xs font-semibold uppercase tracking-wide px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700">
                Periode 2025 – 2028
            </span>

            <h1 class="mt-6 text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Program FPUI 2025–2028
            </h1>

            <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Enam program strategis yang menjadi kerangka kerja FPUI dalam periode
                2025–2028 untuk memperkuat peran perpustakaan umum di seluruh Indonesia.
            </p>

        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-6 py-20">

            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-12">
                Enam Program Strategis
            </h2>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach ($programs as $index => $program)

                    <div
                        x-data="{ show: false }"
                        x-intersect.once="setTimeout(() => show = true, {{ 100 + ($index * 50) }})"
                        :class="show
                            ? 'opacity-100 translate-y-0'
                            : 'opacity-0 translate-y-8'"
                        class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm
                               hover:shadow-xl hover:-translate-y-2
                               transition-all duration-700 ease-out">

                        <span
                            class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600
                                   flex items-center justify-center text-lg font-bold">
                            {{ $program['number'] }}
                        </span>

                        <h3 class="text-lg font-semibold text-gray-900 mt-5 mb-3">
                            {{ $program['title'] }}
                        </h3>

                        <p class="text-sm text-gray-600 leading-relaxed">
                            {{ $program['description'] }}
                        </p>

                    </div>

                @endforeach

            </div>

        </div>
    </section>

@endsection