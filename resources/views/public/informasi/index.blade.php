@extends('layouts.public')

@section('title', $meta['label'])
@section('meta_description', Str::limit($meta['intro'], 155))

@section('content')

    <x-page-hero :title="$meta['label']" :subtitle="$meta['intro']" eyebrow="Informasi" :breadcrumb="[
        ['label' => 'Informasi'],
        ['label' => $meta['label']],
    ]" />

    <div class="max-w-5xl mx-auto px-6 py-14">

        @if ($documents->isEmpty())

            <x-empty-state :title="'Belum ada ' . Str::lower($meta['label'])"
                message="Dokumen pada bagian ini belum dipublikasikan. Silakan kembali lagi nanti." />

        @else

            <ul class="space-y-4">
                @foreach ($documents as $document)
                    @php $downloadUrl = $document->downloadUrl(); @endphp

                    <li
                        class="bg-white border border-gray-100 rounded-2xl p-6 shadow-sm hover:shadow-md transition flex flex-col sm:flex-row sm:items-center gap-5">

                        <div
                            class="w-12 h-12 shrink-0 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7 21h10a2 2 0 002-2V7.5L14.5 3H7a2 2 0 00-2 2v14a2 2 0 002 2zM14 3v5h5" />
                            </svg>
                        </div>

                        <div class="flex-1">
                            <h2 class="font-semibold text-gray-900">{{ $document->title }}</h2>

                            @if ($document->description)
                                <p class="text-sm text-gray-600 mt-1 leading-relaxed">
                                    {{ Str::limit(strip_tags($document->description), 200) }}
                                </p>
                            @endif

                            <div class="mt-2 text-xs text-gray-500">
                                @if ($document->published_at)
                                    {{ $document->published_at->translatedFormat('d F Y') }}
                                @else
                                    {{ $document->created_at->translatedFormat('d F Y') }}
                                @endif
                            </div>
                        </div>

                        @if ($downloadUrl)
                            <a href="{{ $downloadUrl }}" target="_blank" rel="noopener"
                                class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white text-sm font-semibold hover:bg-emerald-700 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 12v8m0 0l-4-4m4 4l4-4M12 4v8" />
                                </svg>
                                {{ $document->file ? 'Unduh' : 'Buka' }}
                            </a>
                        @else
                            <span
                                class="inline-flex items-center justify-center px-4 py-2 rounded-lg bg-gray-100 text-xs font-medium text-gray-500">
                                Segera tersedia
                            </span>
                        @endif

                    </li>
                @endforeach
            </ul>

        @endif

        @if ($documents->hasPages())
            <div class="pt-8">
                {{ $documents->onEachSide(1)->links() }}
            </div>
        @endif

    </div>

@endsection
