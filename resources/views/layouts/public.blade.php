<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Forum Perpustakaan Umum Indonesia')</title>

    <meta name="description" content="@yield('meta_description', 'Kumpulan artikel dan berita terbaru')">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-900 antialiased">

    <header class="bg-white border-b sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="{{ route('home') }}" class="text-xl font-bold text-gray-900">
                FPUI
            </a>

            <nav class="flex items-center gap-6 text-sm font-medium text-gray-700">
                <a href="{{ route('home') }}" class="hover:text-gray-900">Home</a>
                <a href="{{ route('article.index') }}" class="hover:text-gray-900">Artikel</a>
                <a href="{{ route('news.index') }}" class="hover:text-gray-900">Berita</a>
                <a href="{{ route('public.about') }}" class="hover:text-gray-900">Tentang</a>

                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-gray-900">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="hover:text-gray-900">Login</a>
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