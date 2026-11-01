@extends('errors.layout')

@section('title', 'Terlalu Banyak Permintaan')
@section('code', '429')
@section('heading', 'Terlalu Banyak Permintaan')
@section('message', 'Terlalu banyak percobaan dalam waktu singkat. Mohon tunggu beberapa saat sebelum mencoba lagi.')

@section('actions')
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Kembali ke Beranda
    </a>
    <button type="button" onclick="location.reload()"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Coba Lagi
    </button>
@endsection
