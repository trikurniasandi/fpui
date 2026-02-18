<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="bg-gradient-to-r from-emerald-600 to-emerald-500 text-white p-8 rounded-2xl shadow">
                <h3 class="text-2xl font-bold mb-2">
                    Selamat Datang, {{ auth()->user()->name }} !!
                </h3>
                <p class="text-emerald-100">
                    Kelola artikel, berita, kategori, dan profil organisasi melalui dashboard ini.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <p class="text-sm text-gray-500">Total Artikel</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalArticles }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <p class="text-sm text-gray-500">Total Berita</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalNews }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <p class="text-sm text-gray-500">Published</p>
                    <h3 class="text-3xl font-bold text-emerald-600 mt-2">
                        {{ $totalPublished }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <p class="text-sm text-gray-500">Draft</p>
                    <h3 class="text-3xl font-bold text-yellow-500 mt-2">
                        {{ $totalDraft }}
                    </h3>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border">
                    <p class="text-sm text-gray-500">Kategori</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $totalCategories }}
                    </h3>
                </div>

            </div>

            @if($organization)
            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Profil Organisasi
                </h3>

                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">

                    @if($organization->logo)
                        <img src="{{ asset('storage/'.$organization->logo) }}"
                             class="h-20 object-contain">
                    @endif

                    <div class="text-center md:text-left">
                        <p class="text-lg font-semibold text-gray-900">
                            {{ $organization->name }}
                        </p>

                        <p class="text-sm text-gray-500 mt-1">
                            {{ $organization->email }}
                        </p>

                        <p class="text-sm text-gray-500">
                            {{ $organization->phone }}
                        </p>

                        <div class="mt-4">
                            <a href="{{ route('admin.settings.organization.edit', $organization) }}"
                               class="inline-flex px-4 py-2 bg-emerald-600 text-white text-sm font-medium rounded-lg hover:bg-emerald-700 transition">
                                Edit Profil
                            </a>
                        </div>
                    </div>

                </div>
            </div>
            @endif

            <div class="bg-white p-6 rounded-2xl shadow-sm border">
                <h3 class="text-lg font-semibold text-gray-800 mb-6">
                    Akses Cepat
                </h3>

                <div class="flex flex-wrap gap-4">

                    <a href="{{ route('admin.article.create') }}"
                       class="px-5 py-2 bg-emerald-600 text-white rounded-lg text-sm font-medium hover:bg-emerald-700 transition">
                        + Tambah Artikel
                    </a>

                    <a href="{{ route('admin.news.create') }}"
                       class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition">
                        + Tambah Berita
                    </a>

                    <a href="{{ route('admin.settings.category.index') }}"
                       class="px-5 py-2 bg-gray-800 text-white rounded-lg text-sm font-medium hover:bg-gray-900 transition">
                        Kelola Kategori
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>