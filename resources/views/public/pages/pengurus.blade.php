@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    @php
        $groups = $content['groups'] ?? [];
        $hasMembers = collect($groups)->contains(fn($group) => !empty($group['members']));
    @endphp

    <div class="max-w-6xl mx-auto px-6 py-16 space-y-12">

        @if (!$hasMembers)
            <x-empty-state title="Data pengurus sedang diperbarui"
                :message="$content['note'] ?? 'Susunan pengurus akan ditampilkan setelah ditetapkan secara resmi.'" />
        @endif

        @foreach ($groups as $group)
            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-6">{{ $group['title'] }}</h2>

                @if (!empty($group['members']))
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($group['members'] as $member)
                            <div class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm text-center">
                                @if (!empty($member['photo']))
                                    <img src="{{ asset('storage/' . $member['photo']) }}" alt="{{ $member['name'] }}"
                                        class="w-24 h-24 rounded-full object-cover mx-auto mb-4">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full bg-emerald-50 text-emerald-600 text-2xl font-bold flex items-center justify-center mx-auto mb-4">
                                        {{ Str::of($member['name'])->substr(0, 1)->upper() }}
                                    </div>
                                @endif

                                <div class="font-semibold text-gray-900">{{ $member['name'] }}</div>
                                <div class="text-sm text-emerald-700 mt-1">{{ $member['position'] ?? '' }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-8 text-sm text-gray-500 text-center">
                        Data {{ Str::lower($group['title']) }} belum tersedia.
                    </div>
                @endif
            </section>
        @endforeach

        <div class="flex flex-wrap justify-center gap-3 pt-4">
            <a href="{{ route('tentang.struktur-organisasi') }}"
                class="inline-flex px-5 py-2.5 rounded-lg border border-gray-200 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                Struktur Organisasi
            </a>
            <a href="{{ route('organisasi.departemen') }}"
                class="inline-flex px-5 py-2.5 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                Daftar Departemen
            </a>
        </div>

    </div>

@endsection
