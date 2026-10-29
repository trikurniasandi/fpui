<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manajemen Dokumen
            </h2>

            <a href="{{ route('admin.document.create') }}"
                class="inline-flex items-center justify-center w-full sm:w-auto px-4 py-2
                       bg-emerald-600 text-white text-sm font-semibold rounded-lg
                       hover:bg-emerald-700 transition">
                + Tambah Dokumen
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg
                        border border-gray-200 dark:border-gray-700 overflow-hidden">

                <div class="px-4 sm:px-6 py-4 border-b border-gray-200 dark:border-gray-700
                            bg-gray-50 dark:bg-gray-800">
                    <form method="GET" class="mb-4">
                        <div class="flex flex-col gap-3 md:flex-row md:items-end">

                            <div class="flex-1">
                                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Cari</label>
                                <input type="text" name="q" value="{{ request('q') }}"
                                    placeholder="Ketik judul dokumen…"
                                    class="w-full px-3 py-2 text-sm rounded-lg border">
                            </div>

                            <div class="w-full md:w-56">
                                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Jenis</label>
                                <select name="type" class="w-full px-3 py-2 text-sm rounded-lg border">
                                    <option value="">Semua</option>
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}" @selected(request('type') === $key)>
                                            {{ $type['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-full md:w-40">
                                <label class="text-xs font-semibold text-gray-600 dark:text-gray-300">Status</label>
                                <select name="status" class="w-full px-3 py-2 text-sm rounded-lg border">
                                    <option value="">Semua</option>
                                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                                    <option value="published" @selected(request('status') === 'published')>Published</option>
                                </select>
                            </div>

                            <div class="flex gap-2">
                                <button class="px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-lg hover:bg-emerald-700 transition">
                                    Filter
                                </button>
                                <a href="{{ url()->current() }}"
                                    class="px-4 py-2 bg-gray-200 rounded-lg text-sm font-semibold hover:bg-gray-300">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 text-xs sm:text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">No</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Judul</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Jenis</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Tanggal</th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">Status</th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                            @forelse ($documents as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $documents->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $item->title }}
                                        </div>

                                        @if ($item->downloadUrl())
                                            <a href="{{ $item->downloadUrl() }}" target="_blank" rel="noopener"
                                                class="mt-1 inline-block text-xs text-emerald-600 hover:underline">
                                                {{ $item->file ? 'Lihat berkas' : 'Buka tautan' }}
                                            </a>
                                        @endif
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $types[$item->type]['label'] ?? $item->type }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        {{ ($item->published_at ?? $item->created_at)->translatedFormat('d F Y') }}
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
                                            <a href="{{ route('admin.document.edit', $item) }}"
                                                class="inline-flex px-3 py-1.5 bg-blue-500 text-white rounded-md
                                                       text-[11px] sm:text-xs hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <x-confirm-delete :action="route('admin.document.destroy', $item)"
                                                title="Hapus Dokumen"
                                                message="Dokumen ini akan dihapus permanen.">
                                                Hapus
                                            </x-confirm-delete>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada dokumen.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($documents->hasPages())
                    <div class="px-4 sm:px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                        {{ $documents->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
