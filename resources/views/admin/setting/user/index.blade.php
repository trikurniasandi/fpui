<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
                Manajemen Pengguna
            </h2>

            <a href="{{ route('admin.settings.user.create') }}"
               class="inline-flex items-center justify-center
                      w-full sm:w-auto
                      px-4 py-2
                      bg-emerald-600 text-white text-sm font-semibold rounded-lg
                      hover:bg-emerald-700 transition">
                + Tambah Pengguna
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
                        <x-filter-bar 
                            :categories="[]"
                            :search="true"
                            :status="false"
                        />
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
                                    Nama Pengguna
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    E-mail
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Peran
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

                            @forelse ($users as $item)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300">
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>
                                    
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-600 ddark:text-gray-300 whitespace-nowrap">
                                            {{ $item->name }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-600 ddark:text-gray-300 whitespace-nowrap">
                                            {{ $item->email }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-600 ddark:text-gray-300 whitespace-nowrap">
                                            {{ $item->role }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        {{ $item->created_at->translatedFormat('l, d F Y') }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center">
                                        <div class="inline-flex flex-wrap gap-2 justify-end">
                                            <a href="{{ route('admin.settings.user.edit', $item->id) }}"
                                               class="inline-flex px-3 py-1.5 bg-blue-500 text-white
                                                      rounded-md text-[11px] sm:text-xs
                                                      hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <x-confirm-delete
                                                :action="route('admin.settings.user.destroy', $item->id)"
                                                title="Hapus Pengguna"
                                                message="Pengguna ini akan dihapus permanen."
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
                                        Belum ada User.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                @if ($users->hasPages())
                    <div class="px-4 sm:px-6 py-4
                                border-t border-gray-200 dark:border-gray-700">
                        {{ $users->links() }}
                    </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>