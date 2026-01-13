@props([
    'type' => 'success'
])

@php
    $styles = [
        'success' => 'bg-emerald-100 text-emerald-800 border-emerald-300 dark:bg-emerald-900 dark:text-emerald-200',
        'error'   => 'bg-red-100 text-red-800 border-red-300 dark:bg-red-900 dark:text-red-200',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-300 dark:bg-yellow-900 dark:text-yellow-200',
        'info'    => 'bg-blue-100 text-blue-800 border-blue-300 dark:bg-blue-900 dark:text-blue-200',
    ];
@endphp

<div
    x-data="{ show: true }"
    x-show="show"
    x-transition
    class="mb-4 border rounded-lg px-4 py-3 flex justify-between items-start {{ $styles[$type] ?? $styles['info'] }}"
>
    <div class="text-sm font-medium">
        {{ $slot }}
    </div>

    <button
        type="button"
        @click="show = false"
        class="ml-4 text-lg leading-none font-bold opacity-70 hover:opacity-100"
    >
        ×
    </button>
</div>
