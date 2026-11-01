@extends('errors.layout')

@section('title', 'Metode Tidak Diizinkan')
@section('code', '405')
@section('heading', 'Metode Tidak Diizinkan')
@section('message', 'Permintaan Anda menggunakan metode yang tidak didukung oleh halaman ini. Kembali ke halaman sebelumnya atau mulai lagi dari beranda.')

@section('actions')
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Kembali ke Beranda
    </a>
    <button type="button" onclick="history.back()"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Halaman Sebelumnya
    </button>
@endsection
