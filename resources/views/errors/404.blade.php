@extends('errors.layout')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('heading', 'Halaman Tidak Ditemukan')
@section('message', 'Halaman yang Anda cari tidak ada atau sudah dipindahkan. Periksa kembali alamatnya, atau mulai dari beranda.')

@section('actions')
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Kembali ke Beranda
    </a>
    <a href="{{ route('article.index') }}"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Lihat Artikel
    </a>
@endsection
