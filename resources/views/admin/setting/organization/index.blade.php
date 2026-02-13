<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100">
                Profil Organisasi
            </h2>

            @if ($profile == null)
                <a href="{{ route('admin.settings.organization.create') }}" class="inline-flex items-center justify-center
                        px-4 py-2
                        bg-emerald-600 text-white text-sm font-semibold rounded-lg
                        hover:bg-emerald-700 transition">
                    + Tambah Profil
                </a>
            @else
                <a href="{{ route('admin.settings.organization.edit', $profile) }}" class="inline-flex items-center justify-center
                        px-4 py-2
                        bg-emerald-600 text-white text-sm font-semibold rounded-lg
                        hover:bg-emerald-700 transition">
                    Edit Profil
                </a>
            @endif
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-1 space-y-6">

                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6 text-center">

                        <div class="w-36 h-36 mx-auto mb-4
                                    bg-gray-100 dark:bg-gray-700
                                    rounded-xl overflow-hidden flex items-center justify-center">
                            @if(!empty($profile?->logo))
                                <img src="{{ asset('storage/' . $profile->logo) }}" class="w-full h-full object-contain">
                            @else
                                <span class="text-gray-400 text-sm">Logo belum tersedia</span>
                            @endif
                        </div>

                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-100">
                            {{ $profile->name ?? 'Nama belum diisi' }}
                        </h3>

                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-300">
                            {{ $profile->description ?? 'Deskripsi belum tersedia.' }}
                        </p>
                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                            Kontak
                        </h3>

                        <div class="space-y-4 text-sm">
                            <div>
                                <span class="font-medium">Email</span>
                                <div class="mt-1">
                                    @if($profile?->email)
                                        <a href="mailto:{{ $profile->email }}" class="text-blue-600 hover:underline">
                                            {{ $profile->email }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Belum tersedia</span>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <span class="font-medium">Telepon</span>
                                <div class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $profile->phone ?? 'Belum tersedia' }}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="lg:col-span-2 space-y-6">

                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                            Tentang Kami
                        </h3>
                        <div class="prose dark:prose-invert max-w-none text-sm">
                            {!! $profile->about ?? '<span class="text-gray-500">Belum tersedia</span>' !!}
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                                Visi
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-sm">
                                {!! $profile->vision ?? '<span class="text-gray-500">Belum tersedia</span>' !!}
                            </div>
                        </div>

                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                                Misi
                            </h3>
                            <div class="prose dark:prose-invert max-w-none text-sm">
                                {!! $profile->mission ?? '<span class="text-gray-500">Belum tersedia</span>' !!}
                            </div>
                        </div>

                    </div>

                    <div
                        class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                        <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-4">
                            Alamat & Lokasi
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">

                            <div>
                                <span class="font-medium">Alamat</span>
                                <div class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $profile->address ?? 'Belum tersedia' }}
                                </div>
                            </div>

                            <div>
                                <span class="font-medium">Wilayah</span>
                                <div class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $profile->city ?? '-' }}, {{ $profile->province ?? '-' }} <br>
                                    Kode Pos: {{ $profile->postal_code ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <span class="font-medium">Latitude</span>
                                <div class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $profile->latitude ?? '-' }}
                                </div>
                            </div>

                            <div>
                                <span class="font-medium">Longitude</span>
                                <div class="mt-1 text-gray-600 dark:text-gray-300">
                                    {{ $profile->longitude ?? '-' }}
                                </div>
                            </div>
                        </div>

                        @if($profile?->latitude && $profile?->longitude)
                            <div class="mt-6">
                                <a href="https://www.google.com/maps?q={{ $profile->latitude }},{{ $profile->longitude }}"
                                    target="_blank" class="inline-flex items-center px-4 py-2
                                                      bg-blue-600 text-white text-xs font-medium
                                                      rounded-lg hover:bg-blue-700 transition">
                                    Lihat di Google Maps
                                </a>
                            </div>
                        @endif
                    </div>

                    @if($profile?->instagram || $profile?->facebook || $profile?->youtube)
                        <div
                            class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-200 dark:border-gray-700 p-6">
                            <h3 class="text-sm font-semibold uppercase tracking-wide text-gray-500 mb-6">
                                Sosial Media
                            </h3>

                            <div class="flex items-center gap-6">

                                @if($profile?->instagram)
                                    <a href="{{ $profile->instagram }}" target="_blank" class="w-12 h-12 flex items-center justify-center
                                              rounded-full bg-pink-100 text-pink-600
                                              hover:bg-pink-600 hover:text-white
                                              transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                            class="w-6 h-6">
                                            <path
                                                d="M7.75 2h8.5A5.75 5.75 0 0 1 22 7.75v8.5A5.75 5.75 0 0 1 16.25 22h-8.5A5.75 5.75 0 0 1 2 16.25v-8.5A5.75 5.75 0 0 1 7.75 2zm4.25 5a5 5 0 1 0 0 10 5 5 0 0 0 0-10zm6-1.25a1.25 1.25 0 1 0 0 2.5 1.25 1.25 0 0 0 0-2.5z" />
                                        </svg>
                                    </a>
                                @endif

                                @if($profile?->facebook)
                                    <a href="{{ $profile->facebook }}" target="_blank" class="w-12 h-12 flex items-center justify-center
                                              rounded-full bg-blue-100 text-blue-600
                                              hover:bg-blue-600 hover:text-white
                                              transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                            class="w-6 h-6">
                                            <path d="M13 22v-8h3l1-4h-4V8c0-1 .5-2 2-2h2V2h-3c-3 0-5 2-5 5v3H6v4h3v8h4z" />
                                        </svg>
                                    </a>
                                @endif

                                @if($profile?->youtube)
                                    <a href="{{ $profile->youtube }}" target="_blank" class="w-12 h-12 flex items-center justify-center
                                              rounded-full bg-red-100 text-red-600
                                              hover:bg-red-600 hover:text-white
                                              transition duration-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                            class="w-6 h-6">
                                            <path
                                                d="M23 12s0-4-1-6a3 3 0 0 0-2-2C18 3 12 3 12 3s-6 0-8 1a3 3 0 0 0-2 2c-1 2-1 6-1 6s0 4 1 6a3 3 0 0 0 2 2c2 1 8 1 8 1s6 0 8-1a3 3 0 0 0 2-2c1-2 1-6 1-6zM10 15V9l5 3-5 3z" />
                                        </svg>
                                    </a>
                                @endif

                            </div>
                        </div>
                    @endif

                </div>

            </div>

        </div>
    </div>
</x-app-layout>