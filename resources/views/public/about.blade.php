@extends('layouts.public')

@section('title', 'Tentang FPUI')
@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) adalah wadah kolaborasi dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16 space-y-16">

    <section class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            Tentang Forum Perpustakaan Umum Indonesia
        </h1>
        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
            FPUI merupakan wadah kolaborasi nasional untuk pengelola perpustakaan umum di seluruh Indonesia.
            Tujuan utamanya adalah memperkuat literasi, layanan informasi, dan pemberdayaan masyarakat melalui
            perpustakaan yang inklusif dan modern.
        </p>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">Visi</h2>
            <p class="text-gray-600 text-sm leading-relaxed">
                Menjadi forum terdepan yang mendukung pengembangan perpustakaan umum di seluruh Indonesia
                untuk meningkatkan literasi dan pemberdayaan masyarakat.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">Misi</h2>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-2 leading-relaxed">
                <li>Membangun jejaring nasional antar perpustakaan umum.</li>
                <li>Menyediakan sumber daya dan publikasi edukatif untuk pustakawan dan masyarakat.</li>
                <li>Mendorong perpustakaan sebagai ruang inklusif dan inovatif.</li>
                <li>Menjadi pusat informasi dan literasi bagi masyarakat Indonesia.</li>
            </ul>
        </div>
    </section>

    <section class="bg-emerald-600 text-white rounded-3xl p-10 md:p-16 text-center">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">Gabung Bersama Kami</h2>
        <p class="text-lg mb-6 max-w-2xl mx-auto">
            FPUI terbuka untuk semua pengelola perpustakaan umum yang ingin berbagi pengetahuan,
            pengalaman, dan inovasi dalam mengembangkan layanan perpustakaan yang berkualitas.
        </p>
        <a href="#"
           class="inline-flex px-7 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition">
            Daftar Anggota
        </a>
    </section>

</div>
@endsection
