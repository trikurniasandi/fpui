<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100">
                    Tambah Akun Instagram
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Setiap akun memakai access token miliknya sendiri.
                </p>
            </div>

            <a href="{{ route('admin.settings.instagram.index') }}"
               class="inline-flex items-center justify-center
                      w-full sm:w-auto
                      px-4 py-2
                      border border-gray-300 dark:border-gray-600
                      bg-white dark:bg-gray-700 text-gray-700 dark:text-gray-100
                      text-sm font-semibold rounded-lg
                      hover:bg-gray-50 dark:hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('admin.settings.instagram.store') }}"
                  class="space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                @csrf

                @include('admin.setting.instagram._form', ['account' => $account])

                <div class="flex items-center justify-end border-t border-gray-100 pt-5 dark:border-gray-700">
                    <x-primary-button>
                        Simpan Akun
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
