@extends('layouts.public')

@section('title', 'Sejarah FPUI')
@section('meta_description', 'Sejarah berdirinya Forum Perpustakaan Umum Indonesia (FPUI).')

@section('content')

    <section class="bg-gradient-to-b from-emerald-50 to-white">
        <div class="max-w-5xl mx-auto px-6 py-20 text-center">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                Sejarah FPUI
            </h1>
            <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto">
                Perjalanan Forum Perpustakaan Umum Indonesia dalam membangun kolaborasi,
                memperkuat literasi, dan mengembangkan perpustakaan umum di seluruh Indonesia.
            </p>
        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-4xl mx-auto px-6 py-16 space-y-6 text-gray-700 leading-relaxed">

            <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                Latar Belakang Berdirinya
            </h2>

            <p>
                Forum Perpustakaan Umum Indonesia (FPUI) didirikan sebagai wadah kolaborasi
                bagi perpustakaan umum di seluruh Indonesia. Kehadirannya dilatarbelakangi
                oleh kebutuhan akan sinergi, pertukaran pengetahuan, serta penguatan kapasitas
                pengelola perpustakaan dalam menghadapi dinamika perkembangan zaman.
            </p>

            <p>
                FPUI hadir untuk mempertemukan pengelola perpustakaan, pemerintah daerah,
                akademisi, dan komunitas literasi dalam satu ruang komunikasi nasional
                yang terbuka, profesional, dan kolaboratif.
            </p>

        </div>
    </section>

    <section class="bg-gray-50">
        <div class="max-w-4xl mx-auto px-6 py-16">

            <h2 class="text-2xl font-semibold text-gray-900 mb-10 text-center">
                Tonggak Perjalanan
            </h2>

            <div class="relative border-l-2 border-emerald-200 pl-8 space-y-12">

                <div class="relative">
                    <span class="absolute -left-[11px] top-1 w-4 h-4 bg-emerald-600 rounded-full"></span>
                    <h3 class="font-semibold text-gray-900">Fase Inisiasi</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Diskusi dan pertemuan antar pengelola perpustakaan umum
                        untuk membangun jaringan komunikasi nasional.
                    </p>
                </div>

                <div class="relative">
                    <span class="absolute -left-[11px] top-1 w-4 h-4 bg-emerald-600 rounded-full"></span>
                    <h3 class="font-semibold text-gray-900">Pembentukan Resmi</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        FPUI resmi dibentuk sebagai forum komunikasi dan kolaborasi
                        perpustakaan umum di Indonesia.
                    </p>
                </div>

                <div class="relative">
                    <span class="absolute -left-[11px] top-1 w-4 h-4 bg-emerald-600 rounded-full"></span>
                    <h3 class="font-semibold text-gray-900">Penguatan Program Nasional</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Pelaksanaan berbagai seminar, pelatihan, dan forum berbagi
                        praktik baik antar daerah.
                    </p>
                </div>

                <div class="relative">
                    <span class="absolute -left-[11px] top-1 w-4 h-4 bg-emerald-600 rounded-full"></span>
                    <h3 class="font-semibold text-gray-900">Transformasi Digital</h3>
                    <p class="text-sm text-gray-600 mt-2">
                        Adaptasi terhadap perkembangan teknologi informasi
                        untuk meningkatkan layanan dan akses literasi masyarakat.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="bg-white">
        <div class="max-w-5xl mx-auto px-6 py-16">

            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-12">
                Nilai-Nilai Organisasi
            </h2>

            <div class="grid md:grid-cols-2 gap-8">

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Kolaborasi</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Mendorong sinergi antar daerah dan lintas sektor dalam
                        pengembangan perpustakaan umum.
                    </p>
                </div>

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Profesionalisme</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Menjunjung tinggi integritas, kompetensi, dan tata kelola organisasi yang baik.
                    </p>
                </div>

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Transparansi</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Setiap program dan keputusan organisasi dilakukan secara terbuka
                        dan akuntabel.
                    </p>
                </div>

                <div class="p-6 border rounded-xl shadow-sm hover:shadow-md transition">
                    <h4 class="font-semibold text-gray-900 mb-3">Inovasi</h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        Adaptif terhadap perkembangan teknologi dan kebutuhan masyarakat.
                    </p>
                </div>

            </div>

        </div>
    </section>

    <section class="bg-emerald-600 text-white">
        <div class="max-w-4xl mx-auto px-6 py-24 text-center">
            <h4 class="text-2xl md:text-1xl font-semibold mb-6">
                Ingin mengetahui lebih lanjut mengenai struktur dan kepengurusan FPUI?
            </h4>
            <a href="{{ route('profile.structure') }}"
                class="inline-flex px-8 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition shadow-sm">
                Lihat Struktur Organisasi
            </a>
        </div>
    </section>

@endsection