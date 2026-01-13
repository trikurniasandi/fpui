<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Artikel
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('admin.article.update', $article->id) }}" method="POST"
                  class="bg-white dark:bg-gray-800
                         border border-gray-200 dark:border-gray-700
                         rounded-lg shadow-sm p-6 space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Judul Artikel
                    </label>
                    <input type="text"
                           name="title"
                           value="{{ old('title', $article->title) }}"
                           required
                           class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                  dark:bg-gray-900 dark:text-gray-100
                                  focus:border-emerald-500 focus:ring-emerald-500">
                    @error('title')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Konten Artikel
                    </label>
                    <textarea name="content"
                              rows="8"
                              required
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                     dark:bg-gray-900 dark:text-gray-100
                                     focus:border-emerald-500 focus:ring-emerald-500">{{ old('content', $article->content) }}</textarea>
                    @error('content')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Status
                        </label>
                        <select name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                            <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>
                                Draft
                            </option>
                            <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>
                                Published
                            </option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3 justify-end pt-4 border-t border-gray-200 dark:border-gray-700">
                    <a href="{{ route('admin.article.index') }}"
                       class="inline-flex justify-center px-4 py-2
                              border border-gray-300 dark:border-gray-600
                              rounded-lg text-sm font-medium
                              text-gray-700 dark:text-gray-200
                              hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        Batal
                    </a>

                    <button type="submit"
                            class="inline-flex justify-center px-6 py-2
                                   bg-emerald-600 text-white text-sm font-semibold
                                   rounded-lg hover:bg-emerald-700 transition">
                        Perbarui Artikel
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>