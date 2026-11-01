@extends('errors.layout')

@section('title', 'Layanan Sedang Dalam Perawatan')
@section('code', '503')
@section('heading', 'Layanan Sedang Dalam Perawatan')
@section('message', 'Situs sedang diperbarui atau menjalani perawatan terjadwal. Silakan kembali beberapa saat lagi — kami akan segera aktif kembali.')

@section('actions')
    <button type="button" onclick="location.reload()"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Coba Lagi
    </button>
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Kembali ke Beranda
    </a>
@endsection
