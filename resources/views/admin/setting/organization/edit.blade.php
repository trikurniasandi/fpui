<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Profil Organisasi
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('admin.settings.organization.update', $profile) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="bg-white dark:bg-gray-800 
                         border border-gray-200 dark:border-gray-700 
                         rounded-xl shadow-sm p-6 space-y-10">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Informasi Umum
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Nama Organisasi <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $profile->name) }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                          dark:bg-gray-900 dark:text-gray-100
                                          focus:border-emerald-500 focus:ring-emerald-500">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Logo
                            </label>

                            @if($profile->logo)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $profile->logo) }}"
                                         class="h-20 rounded-lg border">
                                </div>
                            @endif

                            <input type="file"
                                   name="logo"
                                   accept="image/*"
                                   class="block w-full text-sm
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-lg file:border-0
                                          file:bg-emerald-600 file:text-white
                                          hover:file:bg-emerald-700">

                            <p class="mt-1 text-xs text-gray-500">
                                Kosongkan jika tidak ingin mengganti logo
                            </p>

                            @error('logo')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Deskripsi Singkat
                            </label>
                            <textarea name="description"
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                             dark:bg-gray-900 dark:text-gray-100">{{ old('description', $profile->description) }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium mb-1">
                                Tentang Kami
                            </label>
                            <textarea name="about"
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                             dark:bg-gray-900 dark:text-gray-100">{{ old('about', $profile->about) }}</textarea>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Visi</label>
                        <x-ckeditor name="vision" id="editor"
                            :value="old('vision', $profile->vision)" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Misi</label>
                        <x-ckeditor name="mission" id="editor2"
                            :value="old('mission', $profile->mission)" />
                    </div>
                </div>

                <div class="space-y-6 border-t pt-8 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Kontak
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="email"
                               name="email"
                               placeholder="Email"
                               value="{{ old('email', $profile->email) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="text"
                               name="phone"
                               placeholder="Telepon"
                               value="{{ old('phone', $profile->phone) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="space-y-6 border-t pt-8 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Alamat
                    </h3>

                    <textarea name="address"
                              rows="3"
                              class="w-full rounded-lg border-gray-300 dark:border-gray-600
                                     dark:bg-gray-900 dark:text-gray-100">{{ old('address', $profile->address) }}</textarea>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <input type="text" name="province"
                               placeholder="Provinsi"
                               value="{{ old('province', $profile->province) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="text" name="city"
                               placeholder="Kota"
                               value="{{ old('city', $profile->city) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="text" name="postal_code"
                               placeholder="Kode Pos"
                               value="{{ old('postal_code', $profile->postal_code) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <input type="text"
                               name="latitude"
                               placeholder="Latitude"
                               value="{{ old('latitude', $profile->latitude) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="text"
                               name="longitude"
                               placeholder="Longitude"
                               value="{{ old('longitude', $profile->longitude) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="space-y-6 border-t pt-8 dark:border-gray-700">
                    <h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wide">
                        Sosial Media
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <input type="url"
                               name="instagram"
                               placeholder="Instagram URL"
                               value="{{ old('instagram', $profile->instagram) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="url"
                               name="facebook"
                               placeholder="Facebook URL"
                               value="{{ old('facebook', $profile->facebook) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">

                        <input type="url"
                               name="youtube"
                               placeholder="YouTube URL"
                               value="{{ old('youtube', $profile->youtube) }}"
                               class="rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-100">
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-6 border-t dark:border-gray-700">
                    <a href="{{ route('admin.settings.organization.index') }}"
                       class="px-4 py-2 rounded-lg border text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                        Batal
                    </a>

                    <button type="submit"
                            class="px-6 py-2 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-700">
                        Update Profil
                    </button>
                </div>

            </form>

        </div>
    </div>
</x-app-layout>