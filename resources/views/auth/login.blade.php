@php
    $watermark = file_exists(public_path('assets/images/logo-watermark.webp'))
        ? 'assets/images/logo-watermark.webp'
        : 'assets/images/logo.png';
@endphp
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk — {{ config('app.name', 'Forum Perpustakaan Umum Indonesia') }}</title>

    @vite(['resources/css/app.css'])

    <style>
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
    </style>
</head>

<body class="min-h-screen bg-gray-50 text-gray-900 antialiased overflow-x-hidden">

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
                class="w-full max-w-md bg-white/85 backdrop-blur rounded-2xl border border-gray-200 shadow-lg p-8 sm:p-10">

                <h1 class="text-2xl font-bold text-gray-900">Masuk ke Akun Anda</h1>

                <p class="mt-2 text-sm text-gray-600 leading-relaxed">
                    Kelola artikel, berita, dan konten situs Forum Perpustakaan Umum Indonesia.
                </p>

                @if (session('status'))
                    <div class="mt-5 rounded-md border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="mt-7 space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            autocomplete="username"
                            class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @error('email')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">Password</label>
                        <input id="password" name="password" type="password" required
                            autocomplete="current-password"
                            class="block w-full rounded-md border-gray-300 shadow-sm text-sm focus:border-emerald-500 focus:ring-emerald-500">
                        @error('password')
                            <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>

                        <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500">
                            <span class="text-sm text-gray-600">Ingat saya</span>
                        </label>

                    </div>

                    <button type="submit"
                        class="w-full inline-flex items-center justify-center rounded-md bg-emerald-600 px-5 py-2.5 text-white font-medium hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition">
                        Masuk
                    </button>

                </form>

                <p class="mt-6 pt-6 border-t border-gray-200 text-center text-sm text-gray-600">
                    Lupa password?
                    <a href="{{ route('kontak.sekretariat') }}"
                        class="font-medium text-emerald-700 hover:text-emerald-800 transition">
                        Hubungi sekretariat
                    </a>
                </p>

            </div>

        </main>

        <footer class="border-t border-gray-200/70 py-5 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} Forum Perpustakaan Umum Indonesia
        </footer>

    </div>

</body>

</html>
