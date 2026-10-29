@props([
    'html' => null,
])

@php
    $sanitizedHtml = app(\App\Services\HtmlSanitizerService::class)->clean($html);
@endphp

@if (filled($sanitizedHtml))
    <div {{ $attributes }}>{!! $sanitizedHtml !!}</div>
@endif
