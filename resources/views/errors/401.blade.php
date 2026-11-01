@extends('errors.layout')

@section('title', 'Perlu Masuk Terlebih Dahulu')
@section('code', '401')
@section('heading', 'Perlu Masuk Terlebih Dahulu')
@section('message', 'Halaman ini hanya dapat diakses setelah Anda masuk. Silakan login dengan akun Anda, lalu buka kembali halaman yang dituju.')

@section('actions')
    <a href="{{ route('login') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Masuk
    </a>
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Kembali ke Beranda
    </a>
@endsection
