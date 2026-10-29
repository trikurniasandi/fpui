<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Forum Perpustakaan Umum Indonesia')</title>

    <meta name="description" content="@yield('meta_description', 'Kumpulan artikel dan berita terbaru')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <header x-data="{ mobileOpen: false }" class="bg-white/90 backdrop-blur border-b sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group select-none shrink-0">
                @if (isset($organization) && $organization && $organization->logo)
                    <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}"
                        class="h-10 sm:h-11 object-contain flex-shrink-0">
                @else
                    <span
                        class="text-2xl sm:text-3xl font-extrabold uppercase tracking-widest text-gray-900 group-hover:text-emerald-700 transition drop-shadow-sm">
                        FPUI
                    </span>
                @endif

                <div class="hidden xl:flex flex-col leading-tight mt-[2px]">
                    <div class="text-[11px] text-gray-500 group-hover:text-emerald-600 transition">
                        Forum Perpustakaan
                    </div>
                    <div class="text-[11px] text-gray-500 group-hover:text-emerald-600 transition">
                        Umum Indonesia
                    </div>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-5 xl:gap-6 text-[13px] font-medium">

                @include('layouts.partials.public-nav-desktop', [
                    'items' => config('public_navigation'),
                    'level' => 0,
                ])

                <span class="h-5 w-px bg-gray-200" aria-hidden="true"></span>

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="whitespace-nowrap text-emerald-700 font-semibold hover:text-emerald-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="whitespace-nowrap inline-flex items-center rounded-md border border-emerald-600 px-4 py-1.5 text-emerald-700 hover:bg-emerald-600 hover:text-white transition">
                        Login
                    </a>
                @endauth
            </nav>

            <button @click="mobileOpen = !mobileOpen"
                class="lg:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 focus:outline-none"
                aria-label="Buka menu">
                <svg x-show="!mobileOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="mobileOpen" x-cloak class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

        </div>

        <div x-cloak x-show="mobileOpen" x-transition class="lg:hidden border-t bg-white max-h-[80vh] overflow-y-auto">
            <nav class="px-4 sm:px-6 py-4 text-sm font-medium">

                @include('layouts.partials.public-nav-mobile', [
                    'items' => config('public_navigation'),
                    'level' => 0,
                ])

                <div class="mt-4 pt-4 border-t">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="block py-2 text-emerald-700 font-semibold">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="inline-flex justify-center w-full rounded-md bg-emerald-600 px-4 py-2 text-white">
                            Login
                        </a>
                    @endauth
                </div>

            </nav>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="border-t bg-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-10 grid gap-8 md:grid-cols-3 text-sm text-gray-500">

            <div>
                <div class="text-base font-semibold text-gray-800 mb-2">
                    {{ $organization->name ?? 'Forum Perpustakaan Umum Indonesia' }}
                </div>
                <p class="leading-relaxed">
                    Wadah kolaborasi nasional untuk memperkuat peran perpustakaan umum di Indonesia.
                </p>
            </div>

            <div>
                <div class="text-base font-semibold text-gray-800 mb-2">Tautan</div>
                <ul class="space-y-1">
                    <li><a href="{{ route('tentang.profil') }}" class="hover:text-emerald-700">Profil</a></li>
                    <li><a href="{{ route('organisasi.keanggotaan') }}" class="hover:text-emerald-700">Keanggotaan</a></li>
                    <li><a href="{{ route('program.program-kerja') }}" class="hover:text-emerald-700">Program Kerja</a></li>
                    <li><a href="{{ route('kontak.hubungi-kami') }}" class="hover:text-emerald-700">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <div class="text-base font-semibold text-gray-800 mb-2">Kontak</div>
                <ul class="space-y-1">
                    @if (!empty($organization?->email))
                        <li><a href="mailto:{{ $organization->email }}" class="hover:text-emerald-700">{{ $organization->email }}</a></li>
                    @endif
                    @if (!empty($organization?->phone))
                        <li>{{ $organization->phone }}</li>
                    @endif
                    <li><a href="{{ route('kontak.sekretariat') }}" class="hover:text-emerald-700">Sekretariat FPUI</a></li>
                </ul>
            </div>

        </div>

        <div class="border-t">
            <div class="max-w-7xl mx-auto px-6 py-5 text-center text-xs text-gray-500">
                © {{ date('Y') }} Forum Perpustakaan Umum Indonesia. All rights reserved.
            </div>
        </div>
    </footer>
    @stack('scripts')
</body>

</html>
