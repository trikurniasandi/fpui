@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    <div class="max-w-6xl mx-auto px-6 py-16 space-y-10">

        <div class="grid md:grid-cols-2 gap-8">

            <section class="bg-white border rounded-2xl p-8 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Visi</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! $organization?->vision ?: '<p>Visi organisasi belum diisi.</p>' !!}
                </div>
            </section>

            <section class="bg-white border rounded-2xl p-8 shadow-sm">
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">Misi</h2>
                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! $organization?->mission ?: '<p>Misi organisasi belum diisi.</p>' !!}
                </div>
            </section>

        </div>

        <div class="flex flex-wrap justify-center gap-3 pt-2">
            <a href="{{ route('tentang.profil') }}"
                class="inline-flex px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Profil Organisasi
            </a>
            <a href="{{ route('program.program-kerja') }}"
                class="inline-flex px-5 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                Program Kerja 2025–2028
            </a>
        </div>

    </div>

@endsection
