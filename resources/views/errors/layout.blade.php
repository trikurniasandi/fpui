@php
    $watermark = file_exists(public_path('assets/images/logo-watermark.webp'))
        ? 'assets/images/logo-watermark.webp'
        : 'assets/images/logo.png';

    $hasBuild = file_exists(public_path('build/manifest.json'));
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Terjadi Kesalahan') — {{ config('app.name', 'Forum Perpustakaan Umum Indonesia') }}</title>

    @if ($hasBuild)
        @vite(['resources/css/app.css'])
    @endif

    <style>
        [x-cloak] {
            display: none !important;
        }

        .err-watermark {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .err-watermark img {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: min(720px, 88vw);
            height: auto;
            opacity: .06;
            filter: grayscale(100%);
        }

        .err-scrim {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            background:
                radial-gradient(circle at 50% 25%, rgba(16, 185, 129, .10), transparent 55%),
                linear-gradient(180deg, rgba(255, 255, 255, .72), rgba(249, 250, 251, .92));
        }

        /* Fallback minimal bila build CSS (Tailwind) belum tersedia. */
        .err-fallback .err-card {
            max-width: 36rem;
            margin: 0 auto;
            background: rgba(255, 255, 255, .85);
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            padding: 2.5rem;
            text-align: center;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased overflow-x-hidden {{ $hasBuild ? '' : 'err-fallback' }}">

    <div class="err-watermark" aria-hidden="true">
        <img src="{{ asset($watermark) }}" alt="" aria-hidden="true">
    </div>

    <div class="err-scrim" aria-hidden="true"></div>

    <div class="relative z-10 min-h-screen flex flex-col">

        <header class="max-w-5xl w-full mx-auto px-6 py-5 flex items-center justify-between gap-4">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group select-none">
                <img src="{{ asset('assets/images/logo.png') }}" alt="Logo FPUI"
                    class="h-11 sm:h-12 w-auto object-contain flex-shrink-0">
                <span class="hidden sm:block text-sm font-semibold text-gray-800 leading-tight">
                    Forum Perpustakaan<br>Umum Indonesia
                </span>
            </a>

            <a href="{{ route('home') }}"
                class="text-sm font-medium text-emerald-700 hover:text-emerald-800 transition">
                Beranda
            </a>

        </header>

        <main class="flex-1 flex items-center justify-center px-4 sm:px-6 py-10">

            <div
                class="err-card w-full max-w-xl bg-white/80 backdrop-blur rounded-2xl border border-gray-200 shadow-lg p-8 sm:p-10 text-center">

                <div
                    class="text-6xl sm:text-7xl font-extrabold tracking-tight text-emerald-600 leading-none tabular-nums">
                    @yield('code', '4xx')
                </div>

                <h1 class="mt-4 text-xl sm:text-2xl font-bold text-gray-900">
                    @yield('heading', 'Terjadi Kesalahan')
                </h1>

                <p class="mt-3 text-sm sm:text-base text-gray-600 leading-relaxed max-w-md mx-auto">
                    @yield('message', 'Permintaan Anda tidak dapat diproses.')
                </p>

                <div class="mt-8 flex flex-col sm:flex-row items-stretch sm:items-center justify-center gap-3">

                    @hasSection('actions')
                        @yield('actions')
                    @else
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 transition">
                            Kembali ke Beranda
                        </a>
                        <button type="button" onclick="history.back()"
                            class="inline-flex items-center justify-center rounded-md border border-gray-300 bg-white px-5 py-2.5 text-gray-700 font-medium hover:bg-gray-50 transition">
                            Halaman Sebelumnya
                        </button>
                    @endif

                </div>

                <p class="mt-6 text-xs text-gray-400">
                    Kode status: @yield('code', '4xx')
                </p>

            </div>

        </main>

        <footer class="border-t border-gray-200/70 py-5 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Forum Perpustakaan Umum Indonesia
        </footer>

    </div>

</body>

</html>
