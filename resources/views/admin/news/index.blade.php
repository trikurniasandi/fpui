<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manajemen Berita
            </h2>

            <a href="{{ route('admin.news.create') }}"
               class="inline-flex items-center justify-center
                      w-full sm:w-auto
                      px-4 py-2
                      bg-emerald-600 text-white text-sm font-semibold rounded-lg
                      hover:bg-emerald-700 transition">
                + Tambah Berita
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800
                        shadow-sm rounded-lg
                        border border-gray-200 dark:border-gray-700
                        overflow-hidden">
                
                <div class="px-4 sm:px-6 py-4
                            border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <x-filter-bar :categories="$categories" />
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700
                                  text-xs sm:text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    No
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Judul
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Kategori
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Dibuat oleh
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Status
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Banner
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Hari/Tanggal
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700
                                      bg-white dark:bg-gray-800">

                            @forelse ($news as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $news->firstItem() + $loop->index }}
                                    </td>
                                    
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item->title }}
                                        </div>
                                        <div class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400 break-all">
                                            {{ $item->slug }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $item->category?->name  ?? '-'}}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $item->author->name ?? '-' }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="inline-flex px-2 py-1 rounded-full
                                                     text-[11px] sm:text-xs font-semibold
                                            {{ $item->status === 'published'
                                                ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900 dark:text-emerald-300'
                                                : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="inline-flex px-2 py-1 rounded-full
                                        text-[11px] sm:text-xs font-semibold
                                        {{ $item->show_on_banner
                                                ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300'
                                                : 'bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-200' }}">
                                            {{ $item->show_on_banner ? 'Yes' : 'No' }}
                                        </span>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        {{ $item->created_at->translatedFormat('l, d F Y') }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <div class="inline-flex flex-wrap gap-2 justify-end">
                                            <a href="{{ route('admin.news.edit', $item->id) }}"
                                               class="inline-flex px-3 py-1.5 bg-blue-500 text-white
                                                      rounded-md text-[11px] sm:text-xs
                                                      hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <x-confirm-delete
                                                :action="route('admin.news.destroy', $item->id)"
                                                title="Hapus Berita"
                                                message="Berita ini akan dihapus permanen."
                                            >
                                                Hapus
                                            </x-confirm-delete>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7"
                                        class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada Berita.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if ($news->hasPages())
                    <div class="px-4 sm:px-6 py-4
                                border-t border-gray-200 dark:border-gray-700">
                        {{ $news->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>