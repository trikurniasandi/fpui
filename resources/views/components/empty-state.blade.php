@props([
    'title' => 'Konten belum tersedia',
    'message' => 'Informasi pada bagian ini sedang disiapkan dan akan segera diperbarui.',
])

<div class="rounded-2xl bg-gray-50 border border-dashed border-gray-300 px-6 py-12 text-center">
    <div class="mx-auto w-12 h-12 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M12 8v4m0 4h.01M4.5 19.5h15a1.5 1.5 0 001.3-2.25l-7.5-13a1.5 1.5 0 00-2.6 0l-7.5 13A1.5 1.5 0 004.5 19.5z" />
        </svg>
    </div>

    <h3 class="mt-4 text-base font-semibold text-gray-800">{{ $title }}</h3>
    <p class="mt-2 text-sm text-gray-500 max-w-xl mx-auto leading-relaxed">{{ $message }}</p>

    @isset($slot)
        <div class="mt-5">{{ $slot }}</div>
    @endisset
</div>
