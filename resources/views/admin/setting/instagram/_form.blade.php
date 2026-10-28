@php
    $expiresAt = $account->token_expires_at;
    $hasToken = $account->exists && $account->hasToken();
@endphp

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="label" value="Label Akun (opsional)" />
        <x-text-input id="label" name="label" type="text"
                      class="mt-1 block w-full"
                      value="{{ old('label', $account->label) }}"
                      placeholder="Contoh: FPUI Pusat" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Nama yang tampil pada tab di beranda. Kosongkan untuk memakai &#64;username.
        </p>
        <x-input-error :messages="$errors->get('label')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="username" value="Username Instagram" />
        <x-text-input id="username" name="username" type="text"
                      class="mt-1 block w-full"
                      value="{{ old('username', $account->username) }}"
                      placeholder="fpui.official" required />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Tanpa tanda &#64;. Setiap akun harus unik.
        </p>
        <x-input-error :messages="$errors->get('username')" class="mt-2" />
    </div>
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="user_id" value="Instagram User ID (opsional)" />
        <x-text-input id="user_id" name="user_id" type="text"
                      class="mt-1 block w-full"
                      value="{{ old('user_id', $account->user_id) }}"
                      placeholder="Kosongkan untuk memakai /me" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Isi hanya jika ingin memakai ID akun secara eksplisit.
        </p>
        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="sort_order" value="Urutan Tampil" />
        <x-text-input id="sort_order" name="sort_order" type="number" min="0" max="9999"
                      class="mt-1 block w-full"
                      value="{{ old('sort_order', $account->sort_order ?? 0) }}" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Akun dengan angka lebih kecil tampil lebih dulu.
        </p>
        <x-input-error :messages="$errors->get('sort_order')" class="mt-2" />
    </div>
</div>

<div>
    <x-input-label for="access_token" value="Access Token" />
    <x-text-input id="access_token" name="access_token" type="password"
                  class="mt-1 block w-full font-mono"
                  autocomplete="new-password"
                  :required="! $account->exists"
                  placeholder="{{ $hasToken ? '•••••••••••• (token tersimpan)' : 'Tempel long-lived access token akun ini' }}" />
    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
        @if ($hasToken)
            Token sudah tersimpan. Biarkan kosong untuk mempertahankan token saat ini.
        @else
            Setiap akun memakai tokennya sendiri. Token tidak akan ditampilkan kembali setelah disimpan.
        @endif
    </p>
    <x-input-error :messages="$errors->get('access_token')" class="mt-2" />
</div>

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
    <div>
        <x-input-label for="token_expires_at" value="Token Kedaluwarsa (opsional)" />
        <x-text-input id="token_expires_at" name="token_expires_at" type="datetime-local"
                      class="mt-1 block w-full"
                      value="{{ old('token_expires_at', $expiresAt?->format('Y-m-d\TH:i')) }}" />
        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
            Kosongkan saat menyimpan token baru untuk memakai estimasi
            {{ (int) config('instagram.token_lifetime_days', 60) }} hari.
        </p>
        <x-input-error :messages="$errors->get('token_expires_at')" class="mt-2" />
    </div>

    <div class="flex flex-col justify-center">
        <label class="inline-flex items-start gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-900/40">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1"
                   class="mt-0.5 rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500"
                   @checked(old('is_active', $account->is_active ?? true))>
            <span>
                <span class="block text-sm font-semibold text-gray-800 dark:text-gray-100">
                    Tampilkan di beranda
                </span>
                <span class="mt-0.5 block text-xs text-gray-500 dark:text-gray-400">
                    Jika dimatikan, akun ini tidak muncul sebagai tab di section Instagram.
                </span>
            </span>
        </label>
        <x-input-error :messages="$errors->get('is_active')" class="mt-2" />
    </div>
</div>
