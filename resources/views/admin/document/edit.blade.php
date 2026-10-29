<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Dokumen
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('admin.document.update', $document) }}" method="POST" enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Informasi Dokumen
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Jenis Dokumen <span class="text-red-500">*</span>
                            </label>
                            <select name="type" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                                @foreach ($types as $key => $type)
                                    <option value="{{ $key }}" @selected(old('type', $document->type) === $key)>
                                        {{ $type['label'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="draft" @selected(old('status', $document->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $document->status) === 'published')>Published</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Judul Dokumen <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $document->title) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-emerald-500 focus:ring-emerald-500">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Deskripsi
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-emerald-500 focus:ring-emerald-500">{{ old('description', $document->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Berkas dan Tautan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Unggah Berkas
                            </label>

                            @if ($document->file)
                                <div class="mb-3">
                                    <a href="{{ asset('storage/' . $document->file) }}" target="_blank" rel="noopener"
                                        class="text-sm text-emerald-600 hover:underline">
                                        Lihat berkas saat ini
                                    </a>
                                </div>
                            @endif

                            <input type="file" name="file"
                                class="block w-full text-sm
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-lg file:border-0
                                       file:bg-emerald-600 file:text-white
                                       hover:file:bg-emerald-700">
                            <p class="mt-1 text-xs text-gray-500">
                                PDF, DOC/DOCX, XLS/XLSX, PPT/PPTX — max 10MB (kosongkan jika tidak diganti)
                            </p>
                            @error('file')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tautan Eksternal
                            </label>
                            <input type="url" name="external_url" value="{{ old('external_url', $document->external_url) }}"
                                placeholder="https://..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="mt-1 text-xs text-gray-500">
                                Isi salah satu: unggah berkas atau tautan eksternal.
                            </p>
                            @error('external_url')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="w-full sm:w-64">
                        <label class="block text-sm font-medium mb-1">
                            Tanggal Publikasi
                        </label>
                        <input type="date" name="published_at"
                            value="{{ old('published_at', $document->published_at?->format('Y-m-d')) }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-emerald-500 focus:ring-emerald-500">
                        @error('published_at')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t dark:border-gray-700">
                    <a href="{{ route('admin.document.index') }}"
                        class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Update Dokumen
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>
