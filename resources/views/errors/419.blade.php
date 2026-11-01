@extends('errors.layout')

@section('title', 'Sesi Anda Telah Berakhir')
@section('code', '419')
@section('heading', 'Sesi Anda Telah Berakhir')
@section('message', 'Halaman ini terlalu lama dibuka sehingga sesi keamanan Anda kedaluwarsa. Muat ulang halaman lalu kirim ulang formulir Anda.')

@section('actions')
    <button type="button" onclick="location.reload()"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Muat Ulang Halaman
    </button>
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Kembali ke Beranda
    </a>
@endsection
