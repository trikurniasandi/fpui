@extends('errors.layout')

@section('title', 'Terjadi Kesalahan pada Server')
@section('code', '500')
@section('heading', 'Terjadi Kesalahan pada Server')
@section('message', 'Maaf, sistem mengalami gangguan saat memproses permintaan Anda. Tim kami sudah menerima catatan kesalahan ini. Silakan coba beberapa saat lagi.')

@section('actions')
    <a href="{{ route('home') }}"
        class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
        Kembali ke Beranda
    </a>
    <button type="button" onclick="location.reload()"
        class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
        Muat Ulang Halaman
    </button>
@endsection
