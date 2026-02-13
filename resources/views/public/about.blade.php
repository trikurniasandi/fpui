@extends('layouts.public')

@section('title', 'Tentang FPUI')
@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) adalah wadah kolaborasi dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-16 space-y-16">

    <section class="text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
            {{ $organization->name }}
        </h1>
        <p class="text-gray-600 text-lg max-w-3xl mx-auto">
          {{ $organization->description }}
        </p>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">Visi</h2>
            <div class="prose max-w-none dark:prose-invert text-gray-600">
                {!! $organization->vision !!}
            </div>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl p-8 shadow-sm hover:shadow-md transition">
            <h2 class="text-2xl font-semibold text-gray-900 mb-3">Misi</h2>
            <div class="prose max-w-none dark:prose-invert text-gray-600">
                {!! $organization->mission !!}
            </div>
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
