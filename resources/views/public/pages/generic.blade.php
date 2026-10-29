@extends('layouts.public')

@section('title', $pageConfig['title'])
@section('meta_description', $pageConfig['meta'] ?? '')

@section('content')

    <x-page-hero :title="$pageConfig['heading'] ?? $pageConfig['title']" :subtitle="$pageConfig['subheading'] ?? null" :eyebrow="$pageConfig['eyebrow'] ?? null"
        :breadcrumb="$pageConfig['breadcrumb'] ?? []" />

    <div class="max-w-6xl mx-auto px-6 py-14 space-y-16">

        @forelse ($content['sections'] ?? [] as $section)
            @include('public.pages.sections.' . $section['type'], ['section' => $section])
        @empty
            <x-empty-state />
        @endforelse

    </div>

@endsection
