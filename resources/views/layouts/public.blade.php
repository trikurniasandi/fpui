<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Forum Perpustakaan Umum Indonesia')</title>

    <meta name="description" content="@yield('meta_description', 'Kumpulan artikel dan berita terbaru')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        [x-cloak] { display: none !important; }
    </style>

</head>

<body class="bg-gray-50 text-gray-900 antialiased">

    <header x-data="{ open: false }" class="bg-white/80 backdrop-blur border-b sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="{{ route('home') }}" class="flex items-center gap-2 group select-none">
                <span
                    class="text-3xl sm:text-4xl font-extrabold uppercase tracking-widest text-gray-900 group-hover:text-emerald-700 transition drop-shadow-sm">
                    FPUI
                </span>

                <div class="hidden sm:block leading-tight mt-[2px]">
                    <div class="text-xs text-gray-500 group-hover:text-emerald-600 transition">
                        Forum Perpustakaan
                    </div>
                    <div class="text-xs text-gray-500 group-hover:text-emerald-600 transition">
                        Umum Indonesia
                    </div>
                </div>
            </a>

            <button @click="open = !open"
                class="md:hidden inline-flex items-center justify-center rounded-md p-2 text-gray-700 hover:bg-gray-100 focus:outline-none">
                <svg x-show="!open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <svg x-show="open" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <nav class="hidden md:flex items-center gap-8 text-sm font-medium">
                <a href="{{ route('home') }}" class="relative text-gray-700 hover:text-emerald-700 transition">
                    Beranda
                </a>

                <a href="{{ route('article.index') }}" class="relative text-gray-700 hover:text-emerald-700 transition">
                    Artikel
                </a>

                <a href="{{ route('news.index') }}" class="relative text-gray-700 hover:text-emerald-700 transition">
                    Berita
                </a>

                <a href="{{ route('public.about') }}" class="relative text-gray-700 hover:text-emerald-700 transition">
                    Tentang
                </a>

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                        class="ml-4 text-emerald-700 font-semibold hover:text-emerald-800 transition">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="ml-4 inline-flex items-center rounded-md border border-emerald-600 px-4 py-1.5 text-emerald-700 hover:bg-emerald-600 hover:text-white transition">
                        Login
                    </a>
                @endauth
            </nav>

        </div>

        <div x-cloak x-show="open" x-transition class="md:hidden border-t bg-white">
            <nav class="flex flex-col px-6 py-4 space-y-3 text-sm font-medium text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-emerald-700">Home</a>
                <a href="{{ route('article.index') }}" class="hover:text-emerald-700">Artikel</a>
                <a href="{{ route('news.index') }}" class="hover:text-emerald-700">Berita</a>
                <a href="{{ route('public.about') }}" class="hover:text-emerald-700">Tentang</a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="pt-2 text-emerald-700 font-semibold">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                    class="mt-2 inline-flex justify-center rounded-md bg-emerald-600 px-4 py-2 text-white">
                        Login
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="border-t bg-white mt-20">
        <div class="max-w-7xl mx-auto px-6 py-8 text-center text-sm text-gray-500">
            © {{ date('Y') }} Forum Perpustakaan Umum Indonesia. All rights reserved.
        </div>
    </footer>

</body>

</html>