@extends('layouts.public')

@section('title', $department['title'] . ' – Departemen FPUI')
@section('meta_description', Str::limit($department['summary'], 155))

@section('content')

    <x-page-hero :title="$department['title']" :subtitle="$department['summary']" eyebrow="Departemen {{ $department['number'] }}" :breadcrumb="[
        ['label' => 'Organisasi'],
        ['label' => 'Departemen', 'route' => 'organisasi.departemen'],
        ['label' => $department['title']],
    ]" />

    <div class="max-w-6xl mx-auto px-6 py-14 grid gap-12 lg:grid-cols-3">

        <div class="lg:col-span-2 space-y-10">

            <section>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Tugas dan Fungsi</h2>

                <ul class="space-y-3">
                    @foreach ($department['duties'] ?? [] as $duty)
                        <li class="flex gap-3 bg-white border border-gray-100 rounded-xl p-4 shadow-sm">
                            <span class="mt-1.5 w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                            <span class="text-sm text-gray-700 leading-relaxed">{{ $duty }}</span>
                        </li>
                    @endforeach
                </ul>
            </section>

            <section class="rounded-2xl bg-emerald-50 border border-emerald-100 p-6">
                <h2 class="text-lg font-semibold text-emerald-900 mb-2">Ingin berkolaborasi?</h2>
                <p class="text-sm text-emerald-800 leading-relaxed">
                    Sampaikan usulan kegiatan atau kerja sama melalui Sekretariat FPUI.
                </p>
                <a href="{{ route('kontak.hubungi-kami') }}"
                    class="inline-flex mt-4 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                    Hubungi Kami
                </a>
            </section>

        </div>

        <aside>
            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Departemen Lain</h3>

            <ul class="space-y-2">
                @foreach ($departments as $slug => $item)
                    <li>
                        <a href="{{ route('organisasi.departemen.show', $slug) }}"
                            class="block px-4 py-3 rounded-xl border text-sm transition
                                {{ $slug === $departemen
                                    ? 'bg-emerald-600 border-emerald-600 text-white font-semibold'
                                    : 'bg-white border-gray-100 text-gray-700 hover:border-emerald-200 hover:text-emerald-700' }}">
                            {{ $item['title'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </aside>

    </div>

@endsection
