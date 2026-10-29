<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit {{ $meta['label_singular'] }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route($meta['admin_route'] . '.update', $publication->id) }}" method="POST"
                enctype="multipart/form-data"
                class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm p-6 space-y-8">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Informasi {{ $meta['label_singular'] }}
                    </h3>

                    <div>
                        <label class="block text-sm font-medium mb-1">
                            Judul {{ $meta['label_singular'] }} <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="title" value="{{ old('title', $publication->title) }}" required
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                   dark:bg-gray-900 dark:text-gray-100
                                   focus:border-emerald-500 focus:ring-emerald-500">
                        @error('title')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if ($meta['has_content'])
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Konten {{ $meta['label_singular'] }}
                                @if ($meta['content_required'])
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>

                            <x-tinymce name="content" id="editor" :value="old('content', $publication->content)" />

                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif

                    @if ($meta['has_video'])
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tautan Video <span class="text-red-500">*</span>
                            </label>
                            <input type="url" name="video_url" value="{{ old('video_url', $publication->video_url) }}" required
                                placeholder="https://www.youtube.com/watch?v=..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                            <p class="mt-1 text-xs text-gray-500">
                                Gunakan tautan video yang dapat diakses publik (YouTube, Vimeo, atau lainnya).
                            </p>
                            @error('video_url')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Media
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                {{ $type === 'infographic' ? 'Gambar Infografis' : 'Foto Utama' }}
                            </label>

                            @if ($publication->thumbnail)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $publication->thumbnail) }}" alt="Thumbnail"
                                        class="h-32 rounded-lg border object-contain bg-gray-50">
                                    <p class="mt-1 text-xs text-gray-500">Foto saat ini</p>
                                </div>
                            @endif

                            <input type="file" name="thumbnail" accept="image/*"
                                @if ($type === 'infographic' && !$publication->thumbnail) required @endif
                                class="block w-full text-sm
                                       file:mr-4 file:py-2 file:px-4
                                       file:rounded-lg file:border-0
                                       file:bg-emerald-600 file:text-white
                                       hover:file:bg-emerald-700">
                            <p class="mt-1 text-xs text-gray-500">
                                JPG, PNG, WEBP — max 2MB (kosongkan jika tidak diganti)
                            </p>
                            @error('thumbnail')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        @if ($meta['has_attachment'])
                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Lampiran
                                </label>

                                @if ($publication->attachment)
                                    <div class="mb-3">
                                        <a href="{{ asset('storage/' . $publication->attachment) }}" target="_blank"
                                            rel="noopener" class="text-sm text-emerald-600 hover:underline">
                                            Lihat lampiran saat ini
                                        </a>
                                    </div>
                                @endif

                                <input type="file" name="attachment"
                                    class="block w-full text-sm
                                           file:mr-4 file:py-2 file:px-4
                                           file:rounded-lg file:border-0
                                           file:bg-gray-200 file:text-gray-700
                                           hover:file:bg-gray-300
                                           dark:file:bg-gray-700 dark:file:text-gray-200">
                                <p class="mt-1 text-xs text-gray-500">
                                    PDF, DOCX, XLSX — max 5MB (opsional)
                                </p>
                                @error('attachment')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Pengaturan
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @if ($meta['has_category'])
                            <div>
                                <label class="block text-sm font-medium mb-1">
                                    Kategori
                                    @if ($meta['category_required'])
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <select name="category_id" @if ($meta['category_required']) required @endif
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                           dark:bg-gray-900 dark:text-gray-100
                                           focus:border-emerald-500 focus:ring-emerald-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $publication->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                       dark:bg-gray-900 dark:text-gray-100
                                       focus:border-emerald-500 focus:ring-emerald-500">
                                <option value="draft" @selected(old('status', $publication->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $publication->status) === 'published')>Published</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    @if ($meta['has_banner'])
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="show_on_banner" name="show_on_banner" value="1"
                                    {{ old('show_on_banner', $publication->show_on_banner) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                <label for="show_on_banner" class="text-sm font-medium">
                                    Tampilkan di Banner Beranda
                                </label>
                            </div>

                            <div id="expiredAtWrapper" class="hidden">
                                <label class="block text-sm font-medium mb-1">
                                    Banner Berakhir Pada
                                </label>
                                <input type="datetime-local" name="expired_at"
                                    value="{{ old('expired_at', $publication->expired_at?->format('Y-m-d\TH:i')) }}"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                           dark:bg-gray-900 dark:text-gray-100
                                           focus:border-emerald-500 focus:ring-emerald-500">
                                <p class="mt-1 text-xs text-gray-500">
                                    Kosongkan jika banner permanen
                                </p>
                                @error('expired_at')
                                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endif
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t dark:border-gray-700">
                    <a href="{{ route($meta['admin_route'] . '.index') }}"
                        class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Update {{ $meta['label_singular'] }}
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>

@if ($meta['has_banner'])
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const checkbox = document.getElementById('show_on_banner');
            const expiredWrapper = document.getElementById('expiredAtWrapper');

            if (!checkbox || !expiredWrapper) return;

            function toggleExpired() {
                expiredWrapper.classList.toggle('hidden', !checkbox.checked);
            }

            toggleExpired();
            checkbox.addEventListener('change', toggleExpired);
        });
    </script>
@endif
