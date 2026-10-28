<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h2 class="font-semibold text-lg sm:text-xl text-gray-800 dark:text-gray-100">
                    Instagram Feed
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Kelola akun Instagram yang tampil di beranda.
                </p>
            </div>

            <a href="{{ route('admin.settings.instagram.create') }}"
               class="inline-flex items-center justify-center
                      w-full sm:w-auto
                      px-4 py-2
                      bg-emerald-600 text-white text-sm font-semibold rounded-lg
                      hover:bg-emerald-700 transition">
                + Tambah Akun
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6 rounded-xl border border-blue-200 bg-blue-50 p-5 dark:border-blue-800 dark:bg-blue-900/30">
                <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                    Beberapa akun, satu section
                </h3>
                <p class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                    Setiap akun memakai access token sendiri dan tampil sebagai tab di section
                    Instagram beranda. Tab hanya muncul jika ada lebih dari satu akun aktif.
                    Command
                    <code class="rounded bg-blue-100 px-1 py-0.5 dark:bg-blue-900">instagram:refresh-token</code>
                    memperbarui token semua akun setiap hari pukul 23.50.
                </p>
            </div>

            <div class="bg-white dark:bg-gray-800
                        shadow-sm rounded-lg
                        border border-gray-200 dark:border-gray-700
                        overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700
                                  text-xs sm:text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700">
                            <tr>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Akun
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Status
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-left font-semibold text-gray-600 dark:text-gray-200">
                                    Token
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">
                                    Urutan
                                </th>
                                <th class="px-4 sm:px-6 py-3 text-center font-semibold text-gray-600 dark:text-gray-200">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700
                                      bg-white dark:bg-gray-800">

                            @forelse ($accounts as $account)
                                @php
                                    $status = $statuses[$account->id] ?? [
                                        'key' => 'not_configured',
                                        'label' => 'Belum dikonfigurasi',
                                        'description' => '',
                                    ];

                                    $statusClasses = match ($status['key']) {
                                        'active' => 'bg-emerald-100 text-emerald-800 border-emerald-200 dark:bg-emerald-900/40 dark:text-emerald-200 dark:border-emerald-800',
                                        'inactive' => 'bg-yellow-100 text-yellow-800 border-yellow-200 dark:bg-yellow-900/40 dark:text-yellow-200 dark:border-yellow-800',
                                        'expiring' => 'bg-amber-100 text-amber-800 border-amber-200 dark:bg-amber-900/40 dark:text-amber-200 dark:border-amber-800',
                                        'expired' => 'bg-red-100 text-red-800 border-red-200 dark:bg-red-900/40 dark:text-red-200 dark:border-red-800',
                                        default => 'bg-gray-100 text-gray-700 border-gray-200 dark:bg-gray-700 dark:text-gray-200 dark:border-gray-600',
                                    };

                                    $expiresAt = $account->token_expires_at;
                                @endphp

                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition align-top">
                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">
                                            {{ $account->displayName() }}
                                        </div>
                                        <div class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400">
                                            &#64;{{ $account->username }}
                                            @if ($account->user_id)
                                                &middot; ID {{ $account->user_id }}
                                            @endif
                                        </div>
                                        @if ($account->account_type)
                                            <div class="text-[11px] sm:text-xs text-gray-500 dark:text-gray-400">
                                                {{ $account->account_type }}
                                            </div>
                                        @endif
                                        @if ($account->last_error)
                                            <div class="mt-2 max-w-sm break-words rounded-md bg-red-50 px-2 py-1 text-[11px] text-red-700 dark:bg-red-900/30 dark:text-red-300">
                                                {{ $account->last_error }}
                                            </div>
                                        @endif
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <span class="inline-flex items-center rounded-full border px-3 py-1 text-[11px] font-semibold {{ $statusClasses }}">
                                            {{ $status['label'] }}
                                        </span>
                                        <p class="mt-2 max-w-[220px] text-[11px] text-gray-500 dark:text-gray-400">
                                            {{ $status['description'] }}
                                        </p>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-gray-600 dark:text-gray-300 whitespace-nowrap">
                                        @if ($expiresAt)
                                            <div class="{{ $expiresAt->isPast() ? 'text-red-600 dark:text-red-400' : '' }}">
                                                {{ $expiresAt->translatedFormat('d F Y H:i') }}
                                            </div>
                                            <div class="text-[11px] text-gray-500 dark:text-gray-400">
                                                {{ $expiresAt->diffForHumans() }}
                                            </div>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">—</span>
                                        @endif
                                        <div class="mt-1 text-[11px] text-gray-500 dark:text-gray-400">
                                            Refresh: {{ $account->last_refreshed_at?->translatedFormat('d F Y H:i') ?? '—' }}
                                        </div>
                                    </td>

                                    <td class="px-4 sm:px-6 py-4 text-center text-gray-600 dark:text-gray-300">
                                        {{ $account->sort_order }}
                                    </td>

                                    <td class="px-4 sm:px-6 py-4">
                                        <div class="flex flex-wrap items-center justify-end gap-2">

                                            <a href="{{ route('admin.settings.instagram.edit', $account) }}"
                                               class="inline-flex px-3 py-1.5 bg-blue-500 text-white
                                                      rounded-md text-[11px] sm:text-xs
                                                      hover:bg-blue-600 transition">
                                                Edit
                                            </a>

                                            <form method="POST" action="{{ route('admin.settings.instagram.test', $account) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex px-3 py-1.5 bg-white text-gray-700
                                                               border border-gray-300 rounded-md text-[11px] sm:text-xs
                                                               hover:bg-gray-50 transition
                                                               dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">
                                                    Test
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.settings.instagram.refresh', $account) }}">
                                                @csrf
                                                <button type="submit"
                                                        @disabled(! $account->hasToken())
                                                        class="inline-flex px-3 py-1.5 bg-white text-gray-700
                                                               border border-gray-300 rounded-md text-[11px] sm:text-xs
                                                               hover:bg-gray-50 transition
                                                               disabled:cursor-not-allowed disabled:opacity-50
                                                               dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">
                                                    Refresh
                                                </button>
                                            </form>

                                            <form method="POST" action="{{ route('admin.settings.instagram.clear-cache', $account) }}">
                                                @csrf
                                                <button type="submit"
                                                        class="inline-flex px-3 py-1.5 bg-white text-gray-700
                                                               border border-gray-300 rounded-md text-[11px] sm:text-xs
                                                               hover:bg-gray-50 transition
                                                               dark:bg-gray-700 dark:text-gray-100 dark:border-gray-600 dark:hover:bg-gray-600">
                                                    Cache
                                                </button>
                                            </form>

                                            <x-confirm-delete
                                                :action="route('admin.settings.instagram.destroy', $account)"
                                                title="Hapus Akun Instagram"
                                                message="Akun ini akan dihapus permanen dan tidak lagi tampil di beranda."
                                            >
                                                Hapus
                                            </x-confirm-delete>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5"
                                        class="px-6 py-10 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada akun Instagram.
                                        <a href="{{ route('admin.settings.instagram.create') }}"
                                           class="font-semibold text-emerald-700 hover:underline dark:text-emerald-400">
                                            Tambah akun pertama
                                        </a>.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-2 text-xs text-gray-500 dark:text-gray-400">
                <span>Versi API: <strong>{{ $apiVersion }}</strong></span>
                <span>Cache feed: <strong>{{ intdiv($cacheTtl, 60) }} menit</strong></span>
                <span>Ambang refresh token: <strong>{{ $refreshThreshold }} hari</strong></span>
            </div>

            <details class="mt-8 rounded-xl border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
                <summary class="cursor-pointer text-base font-semibold text-gray-800 dark:text-gray-100">
                    Panduan Setup Instagram API (Meta for Developers)
                </summary>

                <div class="mt-5 space-y-4 text-sm text-gray-600 dark:text-gray-300">
                    <ol class="list-decimal space-y-3 pl-5">
                        <li>
                            Jadikan setiap akun sebagai akun <strong>Professional</strong>
                            (Business atau Creator) melalui pengaturan Instagram.
                        </li>
                        <li>
                            Buat aplikasi di
                            <a href="https://developers.facebook.com/apps" target="_blank" rel="noopener noreferrer"
                               class="font-semibold text-emerald-700 hover:underline dark:text-emerald-400">
                                developers.facebook.com/apps
                            </a>
                            dengan tipe <strong>Business</strong>.
                        </li>
                        <li>
                            Tambahkan produk <strong>Instagram</strong> lalu pilih
                            <strong>API setup with Instagram login</strong>.
                        </li>
                        <li>
                            Daftarkan akun sebagai <strong>Instagram Tester</strong> di menu
                            App Roles, kemudian terima undangan tersebut dari pengaturan
                            Instagram (Apps and websites &rarr; Tester invites).
                        </li>
                        <li>
                            Generate <strong>long-lived access token</strong> dengan permission
                            <code class="rounded bg-gray-100 px-1 py-0.5 dark:bg-gray-700">instagram_business_basic</code>
                            untuk masing-masing akun.
                        </li>
                        <li>
                            Tambahkan akun melalui tombol <strong>Tambah Akun</strong>, tempel token
                            milik akun tersebut, lalu aktifkan.
                        </li>
                        <li>
                            Klik <strong>Test</strong> pada baris akun. Setelah berhasil, buka beranda
                            untuk memastikan tab akun tampil.
                        </li>
                    </ol>

                    <div class="rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-amber-800 dark:border-amber-800 dark:bg-amber-900/30 dark:text-amber-200">
                        <p class="font-semibold">Catatan penting</p>
                        <ul class="mt-2 list-disc space-y-1 pl-5">
                            <li>Aplikasi Meta boleh tetap dalam mode Development untuk akun sendiri.</li>
                            <li>App Review hanya diperlukan jika feed dipakai untuk akun milik pihak lain.</li>
                            <li>Token baru belum dapat di-refresh dalam 24 jam pertama setelah dibuat.</li>
                            <li>Jangan bagikan token. Setiap token disimpan terenkripsi dengan <code>APP_KEY</code>.</li>
                        </ul>
                    </div>
                </div>
            </details>
        </div>
    </div>
</x-app-layout>
