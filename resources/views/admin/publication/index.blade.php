<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manajemen {{ $meta['label'] }}
            </h2>

            <a href="{{ route($meta['admin_route'] . '.create') }}"
                class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2
                       bg-emerald-600 text-white text-sm font-semibold rounded-lg
                       hover:bg-emerald-700 transition">
                + Tambah {{ $meta['label_singular'] }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg
                        border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <x-filter-bar :categories="$categories" :search="true" :status="true" />
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">No</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Judul</th>
                                @if ($meta['has_category'])
                                    <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Kategori</th>
                                @endif
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Dibuat oleh</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Hari/Tanggal</th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($publications as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $publications->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item->title }}
                                        </div>

                                        @if ($meta['has_video'] && $item->video_url)
                                            <a href="{{ $item->video_url }}" target="_blank" rel="noopener"
                                                class="mt-1 inline-block text-xs text-emerald-600 hover:underline">
                                                Buka tautan video
                                            </a>
                                        @endif
                                    </td>

                                    @if ($meta['has_category'])
                                        <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $item->category->name ?? '-' }}
                                        </td>
                                    @endif

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $item->author->name ?? '-' }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="inline-flex px-2 py-1 rounded-full text-[11px] sm:text-xs font-semibold
                                            {{ $item->status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300'
                                                : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        {{ $item->created_at->translatedFormat('l, d F Y') }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <div class="inline-flex flex-wrap gap-2 justify-end">
                                            <a href="{{ route($meta['admin_route'] . '.edit', $item->id) }}"
                                                class="inline-flex px-3 py-1.5 bg-blue-500 text-white rounded-md
                                                       text-[11px] sm:text-xs hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <x-confirm-delete
                                                :action="route($meta['admin_route'] . '.destroy', $item->id)"
                                                title="Hapus {{ $meta['label_singular'] }}"
                                                message="{{ $meta['label_singular'] }} ini akan dihapus permanen.">
                                                Hapus
                                            </x-confirm-delete>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $meta['has_category'] ? 7 : 6 }}"
                                        class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada {{ Str::lower($meta['label']) }}.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($publications->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $publications->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
