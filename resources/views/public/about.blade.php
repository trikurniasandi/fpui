@extends('layouts.public')

@section('title', 'Tentang FPUI')
@section('meta_description', 'Forum Perpustakaan Umum Indonesia (FPUI) adalah wadah kolaborasi dan pengembangan perpustakaan umum di seluruh Indonesia.')

@section('content')

    @if ($organization)

        <section class="bg-gradient-to-b from-emerald-50 to-white">
            <div class="max-w-5xl mx-auto px-6 py-24 text-center">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                    {{ $organization->name }}
                </h1>
                <p class="mt-6 text-lg text-gray-600 max-w-3xl mx-auto leading-relaxed">
                    {{ $organization->about }}
                </p>
            </div>
        </section>

        <section class="bg-white">
            <div class="max-w-6xl mx-auto px-6 py-20">

                <div class="grid md:grid-cols-2 gap-12">

                    <div class="bg-gray-50 border rounded-2xl p-10 shadow-sm hover:shadow-md transition">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                            Visi
                        </h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed">
                            {!! $organization->vision !!}
                        </div>
                    </div>

                    <div class="bg-gray-50 border rounded-2xl p-10 shadow-sm hover:shadow-md transition">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6">
                            Misi
                        </h2>
                        <div class="prose max-w-none text-gray-600 leading-relaxed">
                            {!! $organization->mission !!}
                        </div>
                    </div>

                </div>

            </div>
        </section>

        <section class="bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 py-20">

                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-gray-900 mb-4">
                        Informasi & Kontak
                    </h2>
                    <p class="text-gray-600 max-w-2xl mx-auto">
                        Hubungi {{ $organization->name }} melalui informasi resmi berikut.
                    </p>
                </div>

                <div class="grid md:grid-cols-3 gap-10 text-center">

                    @if($organization->address || $organization->city || $organization->province)
                        <div class="bg-white p-8 rounded-2xl border shadow-sm hover:shadow-md transition space-y-4">
                            <div
                                class="w-14 h-14 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 21s-6-5.686-6-10a6 6 0 1112 0c0 4.314-6 10-6 10z" />
                                    <circle cx="12" cy="11" r="2.5" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900">Alamat</h4>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $organization->address }}<br>
                                {{ $organization->city }}, {{ $organization->province }}
                                {{ $organization->postal_code }}
                            </p>
                        </div>
                    @endif

                    @if($organization->phone)
                        <div class="bg-white p-8 rounded-2xl border shadow-sm hover:shadow-md transition space-y-4">
                            <div
                                class="w-14 h-14 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2 5a2 2 0 012-2h2.5a1 1 0 01.95.684l1 3a1 1 0 01-.25 1.022l-1.2 1.2a16 16 0 006.586 6.586l1.2-1.2a1 1 0 011.022-.25l3 1A1 1 0 0119.5 17.5V20a2 2 0 01-2 2h-1C7.94 22 2 16.06 2 8.5V7a2 2 0 012-2z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900">Telepon</h4>
                            <a href="tel:{{ preg_replace('/[^0-9]/', '', $organization->phone) }}"
                                class="text-emerald-600 hover:text-emerald-700 transition">
                                {{ $organization->phone }}
                            </a>
                        </div>
                    @endif

                    @if($organization->email)
                        <div class="bg-white p-8 rounded-2xl border shadow-sm hover:shadow-md transition space-y-4">
                            <div
                                class="w-14 h-14 mx-auto rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" stroke="currentColor"
                                    stroke-width="1.8" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 8l9 6 9-6M4 6h16a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V7a1 1 0 011-1z" />
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900">Email</h4>
                            <a href="mailto:{{ $organization->email }}" class="text-emerald-600 hover:text-emerald-700 transition">
                                {{ $organization->email }}
                            </a>
                        </div>
                    @endif

                </div>

            </div>
        </section>

        @if($organization->latitude && $organization->longitude)
            <section class="bg-white">
                <div class="max-w-6xl mx-auto px-6 py-20">
                    <div class="rounded-3xl overflow-hidden shadow-lg border">
                        <iframe width="100%" height="450" style="border:0" loading="lazy" allowfullscreen
                            src="https://www.google.com/maps?q={{ $organization->latitude }},{{ $organization->longitude }}&hl=id&z=16&output=embed">
                        </iframe>
                    </div>
                </div>
            </section>
        @endif

        <section class="bg-gray-50 border-y">
            <div class="max-w-4xl mx-auto px-6 py-20 text-center">

                <h3 class="text-2xl font-semibold text-gray-900 mb-10">
                    Media Sosial
                </h3>

                <div class="flex justify-center gap-8">

                    @if($organization->instagram)
                        <a href="{{ $organization->instagram }}" target="_blank"
                            class="w-14 h-14 flex items-center justify-center rounded-full bg-white border shadow-sm hover:bg-emerald-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M7.75 2C4.574 2 2 4.574 2 7.75v8.5C2 19.426 4.574 22 7.75 22h8.5C19.426 22 22 19.426 22 16.25v-8.5C22 4.574 19.426 2 16.25 2h-8.5zm0 2h8.5C18.284 4 20 5.716 20 7.75v8.5C20 18.284 18.284 20 16.25 20h-8.5C5.716 20 4 18.284 4 16.25v-8.5C4 5.716 5.716 4 7.75 4zm9.5 1.5a1 1 0 110 2 1 1 0 010-2zM12 7a5 5 0 100 10 5 5 0 000-10zm0 2a3 3 0 110 6 3 3 0 010-6z" />
                            </svg>
                        </a>
                    @endif

                    @if($organization->facebook)
                        <a href="{{ $organization->facebook }}" target="_blank"
                            class="w-14 h-14 flex items-center justify-center rounded-full bg-white border shadow-sm hover:bg-emerald-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M13 22v-8h3l1-4h-4V8c0-1.2.3-2 2-2h2V2.1C16.6 2 15.3 2 14 2c-3 0-5 1.8-5 5v3H6v4h3v8h4z" />
                            </svg>
                        </a>
                    @endif

                    @if($organization->youtube)
                        <a href="{{ $organization->youtube }}" target="_blank"
                            class="w-14 h-14 flex items-center justify-center rounded-full bg-white border shadow-sm hover:bg-emerald-600 hover:text-white transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M21.8 8s-.2-1.5-.8-2.1c-.8-.8-1.6-.8-2-.9C16.1 4.8 12 4.8 12 4.8h0s-4.1 0-7 .2c-.4.1-1.2.1-2 .9C2.4 6.5 2.2 8 2.2 8S2 9.6 2 11.3v1.4C2 14.4 2.2 16 2.2 16s.2 1.5.8 2.1c.8.8 1.8.8 2.3.9 1.7.2 6.7.2 6.7.2s4.1 0 7-.2c.4-.1 1.2-.1 2-.9.6-.6.8-2.1.8-2.1s.2-1.6.2-3.3v-1.4C22 9.6 21.8 8 21.8 8zM10 14V9l5 2.5L10 14z" />
                            </svg>
                        </a>
                    @endif

                </div>

            </div>
        </section>

        <section class="bg-emerald-600 text-white">
            <div class="max-w-4xl mx-auto px-6 py-24 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">
                    Gabung Bersama Kami
                </h2>
                <p class="text-lg mb-8 max-w-2xl mx-auto leading-relaxed">
                    FPUI terbuka untuk seluruh pengelola perpustakaan umum yang ingin
                    berkolaborasi dan berkontribusi dalam penguatan literasi nasional.
                </p>
                <a href="#"
                    class="inline-flex px-8 py-3 bg-white text-emerald-700 font-semibold rounded-xl hover:bg-gray-100 transition shadow-sm">
                    Daftar Anggota
                </a>
            </div>
        </section>

    @else

        <div class="text-center py-32">
            <h1 class="text-3xl font-semibold text-gray-900 mb-4">
                Data Organisasi Belum Tersedia
            </h1>
            <p class="text-gray-600">
                Informasi tentang organisasi akan segera diperbarui.
            </p>
        </div>

    @endif

@endsection