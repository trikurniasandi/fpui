@extends('errors.layout')

@section('title', 'Akses Ditolak')
@section('code', '403')
@section('heading', 'Akses Ditolak')
@section('message', 'Anda tidak memiliki izin untuk membuka halaman ini. Silakan masuk dengan akun yang sesuai atau kembali ke beranda.')

@section('actions')
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Kembali ke Beranda
    </a>

    @auth
        <a href="{{ route('admin.dashboard') }}"
            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
            Ke Dashboard
        </a>
    @else
        <a href="{{ route('login') }}"
            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
            Masuk
        </a>
    @endauth
@endsection
