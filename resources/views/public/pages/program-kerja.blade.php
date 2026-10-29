@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    @php
        $programs = $content['items'] ?? [];
    @endphp

    <section class="bg-white">
        <div class="max-w-6xl mx-auto px-6 py-20">

            <h2 class="text-2xl font-semibold text-gray-900 text-center mb-12">
                Enam Program Strategis
            </h2>

            @if (count($programs))
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">

                    @foreach ($programs as $index => $program)
                        <div x-data="{ show: false }" x-intersect.once="setTimeout(() => show = true, {{ 100 + ($index * 50) }})"
                            :class="show ?
                                'opacity-100 translate-y-0' :
                                'opacity-0 translate-y-8'"
                            class="bg-white border border-gray-100 rounded-2xl p-8 shadow-sm
                                   hover:shadow-xl hover:-translate-y-2
                                   transition-all duration-700 ease-out">

                            <span
                                class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-600
                                       flex items-center justify-center text-lg font-bold">
                                {{ $program['number'] }}
                            </span>

                            <h3 class="text-lg font-semibold text-gray-900 mt-5 mb-3">
                                {{ $program['title'] }}
                            </h3>

                            <p class="text-sm text-gray-600 leading-relaxed">
                                {{ $program['description'] }}
                            </p>

                        </div>
                    @endforeach

                </div>
            @else
                <x-empty-state message="Program kerja belum tersedia." />
            @endif

        </div>
    </section>

    <section class="bg-gray-50 border-t">
        <div class="max-w-4xl mx-auto px-6 py-16 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">
                Ingin mengetahui kegiatan yang sedang berjalan?
            </h3>
            <div class="flex flex-wrap justify-center gap-3 mt-6">
                <a href="{{ route('program.agenda') }}"
                    class="inline-flex px-5 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                    Lihat Agenda
                </a>
                <a href="{{ route('program.kegiatan') }}"
                    class="inline-flex px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-white transition">
                    Lihat Kegiatan
                </a>
            </div>
        </div>
    </section>

@endsection
