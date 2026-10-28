@php
    $accountsPayload = $accounts->values()->all();
    $initialAccount = $accountsPayload[0] ?? null;
@endphp

<section
    x-data="instagramFeedTabs({{ Js::from($accountsPayload) }})"
    class="max-w-7xl mx-auto px-6"
>
    <div class="rounded-3xl border border-gray-100 bg-white p-8 shadow-sm sm:p-10">

        <div class="mb-8 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-600">
                    Sosial Media
                </span>
                <h2 class="mt-2 text-3xl font-bold text-gray-900">
                    Ikuti Kami di Instagram
                </h2>
                <p class="mt-2 max-w-2xl text-sm text-gray-600">
                    Kegiatan, program, dan kabar terbaru langsung dari
                    <a :href="current ? current.profile_url : '#'" target="_blank" rel="noopener noreferrer"
                       class="font-semibold text-emerald-700 hover:text-emerald-800">
                        &#64;<span x-text="current ? current.username : {{ Js::from($initialAccount['username'] ?? '') }}">{{ $initialAccount['username'] ?? '' }}</span>
                    </a>.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <a :href="current ? current.profile_url : '#'" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 rounded-xl bg-gradient-to-br from-fuchsia-600 via-rose-500 to-amber-400 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:opacity-90">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                        <circle cx="12" cy="12" r="4"></circle>
                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle>
                    </svg>
                    <span class="hidden sm:inline">Buka Instagram</span>
                </a>
            </div>
        </div>

        {{-- Tab bar hanya tampil jika ada lebih dari satu akun --}}
        @if ($accounts->count() > 1)
            <div class="mb-6 flex flex-wrap gap-2 border-b border-gray-100 pb-4"
                 role="tablist" aria-label="Akun Instagram">
                <template x-for="account in accounts" :key="account.id">
                    <button type="button"
                            role="tab"
                            :aria-selected="active === account.id"
                            :aria-controls="'instagram-panel-' + account.id"
                            @click="select(account.id)"
                            :class="active === account.id
                                ? 'border-emerald-600 bg-emerald-600 text-white shadow-sm'
                                : 'border-gray-200 bg-white text-gray-600 hover:border-emerald-200 hover:text-emerald-700'"
                            class="inline-flex items-center rounded-full border px-4 py-2 text-sm font-semibold transition">
                        <span x-text="account.label"></span>
                    </button>
                </template>
            </div>
        @endif

        @foreach ($accounts as $account)
            <div id="instagram-panel-{{ $account['id'] }}"
                 x-show="active === '{{ $account['id'] }}'"
                 x-cloak
                 role="tabpanel">
                <div
                    x-data="instagramFeedPanel({
                        endpoint: {{ Js::from($account['endpoint']) }},
                        profileUrl: {{ Js::from($account['profile_url']) }},
                        username: {{ Js::from($account['username']) }},
                        isActive: active === '{{ $account['id'] }}'
                    })"
                    x-effect="syncActive(active === '{{ $account['id'] }}')"
                >
                    {{-- Navigasi carousel --}}
                    <div class="mb-4 flex items-center justify-between gap-4">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-400">
                            Postingan terbaru
                        </p>

                        <div class="flex items-center gap-2">
                            <button type="button"
                                    @click="scroll(-1)"
                                    :disabled="atStart || loading || posts.length === 0"
                                    aria-label="Postingan sebelumnya"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-emerald-200 hover:text-emerald-700 disabled:cursor-not-allowed disabled:opacity-40">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>

                            <button type="button"
                                    @click="scroll(1)"
                                    :disabled="atEnd || loading || posts.length === 0"
                                    aria-label="Postingan berikutnya"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 transition hover:border-emerald-200 hover:text-emerald-700 disabled:cursor-not-allowed disabled:opacity-40">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    {{-- Loading skeleton --}}
                    <div x-show="loading" x-cloak class="flex gap-6 overflow-hidden" aria-hidden="true">
                        <template x-for="i in 4" :key="i">
                            <div class="w-[260px] shrink-0 animate-pulse rounded-2xl border border-gray-100 bg-white p-3 sm:w-[280px]">
                                <div class="aspect-square rounded-xl bg-gray-200"></div>
                                <div class="mt-4 h-3 w-3/4 rounded bg-gray-200"></div>
                                <div class="mt-2 h-3 w-1/2 rounded bg-gray-200"></div>
                                <div class="mt-5 h-3 w-1/3 rounded bg-gray-200"></div>
                            </div>
                        </template>
                    </div>

                    {{-- Empty / error state --}}
                    <div x-show="!loading && posts.length === 0" x-cloak
                         class="rounded-2xl border border-dashed border-gray-200 bg-gray-50 px-6 py-12 text-center">
                        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-fuchsia-600 via-rose-500 to-amber-400 text-white">
                            <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                <circle cx="12" cy="12" r="4"></circle>
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle>
                            </svg>
                        </div>

                        <h3 class="text-lg font-semibold text-gray-900"
                            x-text="error ? 'Feed Instagram belum dapat dimuat' : 'Belum ada postingan untuk ditampilkan'"></h3>

                        <p class="mx-auto mt-2 max-w-md text-sm text-gray-600"
                           x-text="error
                                ? 'Periksa koneksi internet Anda atau coba beberapa saat lagi.'
                                : 'Postingan terbaru dari @' + username + ' akan muncul di sini.'"></p>

                        <div class="mt-6 flex flex-wrap items-center justify-center gap-3">
                            <button type="button" x-show="error" @click="fetchFeed()"
                                    class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                Coba Lagi
                            </button>

                            <a :href="profileUrl" target="_blank" rel="noopener noreferrer"
                               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 transition hover:border-emerald-200 hover:text-emerald-700">
                                Buka Instagram
                            </a>
                        </div>
                    </div>

                    {{-- Carousel --}}
                    <div x-show="!loading && posts.length > 0" x-cloak class="relative">
                        <div x-ref="track"
                             @scroll.debounce.100ms="updateScrollState()"
                             class="flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-4 [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

                            <template x-for="post in posts" :key="post.id">
                                <article data-instagram-card
                                         class="group w-[260px] shrink-0 snap-start overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:shadow-xl sm:w-[280px]">

                                    <a :href="post.permalink" target="_blank" rel="noopener noreferrer"
                                       class="relative block aspect-square overflow-hidden bg-gradient-to-br from-fuchsia-600 via-rose-500 to-amber-400">

                                        <div class="absolute inset-0 flex items-center justify-center text-white/90">
                                            <svg class="h-10 w-10" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                                <circle cx="12" cy="12" r="4"></circle>
                                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle>
                                            </svg>
                                        </div>

                                        <img :src="post.image"
                                             :alt="post.alt"
                                             loading="lazy"
                                             decoding="async"
                                             class="relative h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                             x-on:error="$el.style.display = 'none'">

                                        <span x-show="post.is_video"
                                              class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-black/60 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                            <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M8 5v14l11-7z"></path>
                                            </svg>
                                            Video
                                        </span>

                                        <span x-show="post.is_carousel"
                                              class="absolute left-3 top-3 inline-flex items-center gap-1 rounded-full bg-black/60 px-2.5 py-1 text-[11px] font-semibold text-white backdrop-blur">
                                            <svg class="h-3 w-3" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="8" y="8" width="12" height="12" rx="2"></rect>
                                                <path stroke-linecap="round" d="M16 8V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2"></path>
                                            </svg>
                                            Album
                                        </span>

                                        <div class="absolute inset-0 flex items-center justify-center bg-black/0 opacity-0 transition group-hover:bg-black/25 group-hover:opacity-100">
                                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24" aria-hidden="true">
                                                <rect x="3" y="3" width="18" height="18" rx="5"></rect>
                                                <circle cx="12" cy="12" r="4"></circle>
                                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"></circle>
                                            </svg>
                                        </div>
                                    </a>

                                    <div class="p-4">
                                        <div class="flex items-center justify-between gap-2 text-xs text-gray-500">
                                            <span class="truncate font-semibold text-gray-700"
                                                  x-text="'@' + post.username"></span>
                                            <span class="shrink-0" x-text="post.relative_date"></span>
                                        </div>

                                        <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-gray-600"
                                           x-text="post.caption || 'Lihat postingan ini di Instagram.'"></p>

                                        <a :href="post.permalink" target="_blank" rel="noopener noreferrer"
                                           class="mt-4 inline-flex items-center gap-1 text-xs font-semibold text-emerald-700 transition hover:text-emerald-800">
                                            Lihat Postingan
                                            <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </a>
                                    </div>
                                </article>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</section>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('instagramFeedTabs', (accounts = []) => ({
        accounts: Array.isArray(accounts) ? accounts : [],
        active: null,

        init() {
            this.active = this.accounts.length ? this.accounts[0].id : null;
        },

        get current() {
            return this.accounts.find((account) => account.id === this.active)
                || this.accounts[0]
                || null;
        },

        select(id) {
            this.active = id;
        },
    }));

    Alpine.data('instagramFeedPanel', (config = {}) => ({
        endpoint: config.endpoint || '',
        profileUrl: config.profileUrl || 'https://www.instagram.com/',
        username: config.username || '',
        posts: [],
        loading: false,
        loaded: false,
        error: false,
        atStart: true,
        atEnd: true,
        isActive: Boolean(config.isActive),

        init() {
            if (this.isActive) {
                this.activate();
            }
        },

        syncActive(isActive) {
            this.isActive = Boolean(isActive);

            if (this.isActive) {
                this.activate();
            }
        },

        activate() {
            if (this.loaded || this.loading) {
                return;
            }

            this.fetchFeed();
        },

        async fetchFeed() {
            if (!this.endpoint) {
                this.loading = false;
                this.loaded = true;
                this.error = true;

                return;
            }

            this.loading = true;
            this.error = false;

            try {
                const response = await fetch(this.endpoint, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    credentials: 'same-origin',
                });

                if (!response.ok) {
                    throw new Error('HTTP ' + response.status);
                }

                const data = await response.json();

                this.posts = Array.isArray(data.posts) ? data.posts : [];
                this.username = data.username || this.username;
                this.profileUrl = data.profile_url || this.profileUrl;
            } catch (error) {
                this.posts = [];
                this.error = true;
            } finally {
                this.loading = false;
                this.loaded = true;
                this.$nextTick(() => this.updateScrollState());
            }
        },

        scroll(direction) {
            const track = this.$refs.track;

            if (!track) {
                return;
            }

            const card = track.querySelector('[data-instagram-card]');
            const distance = card
                ? card.offsetWidth + 24
                : Math.round(track.clientWidth * 0.8);

            track.scrollBy({ left: direction * distance, behavior: 'smooth' });
        },

        updateScrollState() {
            const track = this.$refs.track;

            if (!track) {
                this.atStart = true;
                this.atEnd = true;

                return;
            }

            this.atStart = track.scrollLeft <= 4;
            this.atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 4;
        },
    }));
});
</script>
@endpush
