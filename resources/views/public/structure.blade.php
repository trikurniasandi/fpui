@extends('layouts.public')

@section('title', 'Struktur Organisasi FPUI')
@section('meta_description', 'Struktur organisasi Forum Perpustakaan Umum Indonesia (FPUI).')

@section('content')

    <section class="bg-gradient-to-b from-emerald-50 to-white">
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Struktur Organisasi
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto">
                Susunan kepengurusan Forum Perpustakaan Umum Indonesia (FPUI)
                dalam menjalankan visi, misi, dan program organisasi secara profesional dan kolaboratif.
            </p>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-4xl mx-auto px-6 py-16 text-gray-700 leading-relaxed space-y-6">

            <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                Tata Kelola Organisasi
            </h2>

            <p>
                Struktur organisasi FPUI dirancang untuk memastikan koordinasi yang efektif,
                pengambilan keputusan yang transparan, serta pelaksanaan program yang terarah
                dalam mendukung penguatan perpustakaan umum di Indonesia.
            </p>

            <p>
                Setiap bidang memiliki peran strategis dalam pengembangan literasi,
                peningkatan kapasitas pengelola perpustakaan, serta kolaborasi lintas daerah
                dan pemangku kepentingan.
            </p>

        </div>
    </section>

    <section class="bg-gray-50">
        <div class="max-w-6xl mx-auto px-6 py-16">

            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-12">
                Susunan Kepengurusan
            </h2>

            <div class="bg-white border rounded-2xl shadow-sm p-6 md:p-10">
                <div class="flex justify-center">
                    <img src="{{ asset('assets/images/structure.png') }}" alt="Struktur Organisasi FPUI"
                        class="w-full max-w-5xl rounded-xl shadow-md object-contain hover:scale-[1.01] transition duration-300">
                </div>
            </div>

        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-6 py-16">

            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-12">
                Prinsip Kepengurusan
            </h2>

            <div class="grid md:grid-cols-3 gap-8">

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Transparansi</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap keputusan dan kegiatan organisasi dilakukan secara terbuka
                        dan dapat dipertanggungjawabkan kepada anggota.
                    </p>
                </div>

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Kolaboratif</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Pengurus bekerja secara sinergis antar bidang untuk memastikan
                        program berjalan efektif dan berdampak luas.
                    </p>
                </div>

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Profesional</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menjunjung integritas, kompetensi, serta tata kelola organisasi
                        yang baik dalam setiap tanggung jawab.
                    </p>
                </div>

            </div>

        </div>
    </section>

     <section class="bg-emerald-600 text-white">
        <div class="max-w-4xl mx-auto px-6 py-24 text-center">
            <h4 class="text-2xl md:text-1xl font-semibold mb-6">
                Pelajari lebih lanjut mengenai perjalanan FPUI.
            </h4>
            <a href="{{ route('profile.history') }}"
                class="inline-flex px-8 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition shadow-sm">
                Lihat Sejarah FPUI
            </a>
        </div>
    </section>

@endsection