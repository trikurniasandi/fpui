<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manajemen Galeri Foto
            </h2>

            <a href="{{ route('admin.photo.create') }}"
                class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2
                       bg-emerald-600 text-white text-sm font-semibold rounded-lg
                       hover:bg-emerald-700 transition">
                + Tambah Foto
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg
                        border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <x-filter-bar :categories="[]" :search="true" :status="true" />
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">No</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Foto</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Judul</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Tanggal</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($photos as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $photos->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}"
                                            class="h-14 w-20 rounded-lg object-cover border">
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item->title }}
                                        </div>
                                        @if ($item->description)
                                            <div class="mt-1 text-xs text-gray-500 line-clamp-1">
                                                {{ Str::limit(strip_tags($item->description), 80) }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        {{ ($item->taken_at ?? $item->created_at)->translatedFormat('d F Y') }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="inline-flex px-2 py-1 rounded-full text-[11px] sm:text-xs font-semibold
                                            {{ $item->status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300'
                                                : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <div class="inline-flex flex-wrap gap-2 justify-end">
                                            <a href="{{ route('admin.photo.edit', $item) }}"
                                                class="inline-flex px-3 py-1.5 bg-blue-500 text-white rounded-md
                                                       text-[11px] sm:text-xs hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <x-confirm-delete :action="route('admin.photo.destroy', $item)"
                                                title="Hapus Foto"
                                                message="Foto ini akan dihapus permanen.">
                                                Hapus
                                            </x-confirm-delete>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada foto.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($photos->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $photos->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
