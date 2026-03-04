<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Tambah Banner
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 space-y-8">
                @csrf

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Informasi Banner
                    </h3>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Judul Banner <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-emerald-500 focus:ring-emerald-500">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Deskripsi Banner <span class="text-red-500">*</span>
                        </label>

                        <x-tinymce name="content" id="editor" :value="old('content')" />

                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Pengaturan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                       

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                  
                        <div id="expiredAtWrapper" class="">
                            <label class="block text-sm font-medium mb-1">
                                Banner Berakhir Pada
                            </label>
                            <input type="datetime-local"
                                name="expired_at"
                                value="{{ old('expired_at') }}"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                        dark:bg-gray-900 dark:text-gray-100
                                        focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan jika banner tidak memiliki batas waktu
                            </p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Media
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Foto Banner <span class="text-red-500">*</span>
                            </label>
                            <input type="file" name="thumbnail" accept="image/*"
                                class="block w-full text-sm
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-lg file:border-0
                                file:bg-emerald-600 file:text-white
                                hover:file:bg-emerald-700">
                            <p class="mt-1 text-xs text-gray-500">JPG, PNG, WEBP — max 2MB</p>
                            @error('thumbnail')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t dark:border-gray-700">
                    <a href="{{ route('admin.banner.index') }}"
                        class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Simpan Banner
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>