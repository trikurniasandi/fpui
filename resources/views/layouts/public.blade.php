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

    <header x-data="{ open: false }" class="bg-white/80 backdrop-blur border-b sticky top-0 z-50">

        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">

            <a href="{{ route('home') }}" class="flex items-center gap-3 group select-none">
                @if($organization && $organization->logo)
                    <img src="{{ asset('storage/' . $organization->logo) }}" alt="{{ $organization->name }}"
                        class="h-10 sm:h-12 object-contain flex-shrink-0">
                @else
                    <span
                        class="text-2xl sm:text-3xl font-extrabold uppercase tracking-widest text-gray-900 group-hover:text-emerald-700 transition drop-shadow-sm">
                        FPUI
                    </span>
                @endif
                <div class="hidden sm:flex flex-col leading-tight mt-[2px]">
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

                @foreach(config('public_navigation') as $menu)

                    @if(!isset($menu['children']))

                            @php
                                $isActive = request()->routeIs($menu['active_pattern'] ?? $menu['route']);
                            @endphp

                            <a href="{{ route($menu['route']) }}" class="relative transition duration-200
                                       {{ $isActive
                        ? 'text-emerald-700 font-semibold'
                        : 'text-gray-700 hover:text-emerald-700' }}">
                                {{ $menu['label'] }}
                            </a>
                    @else

                            @php
                                $isParentActive = collect($menu['children'])
                                    ->pluck('active_pattern')
                                    ->filter()
                                    ->contains(fn($pattern) => request()->routeIs($pattern));
                            @endphp

                            <div x-data="{ openDropdown: false }" @mouseenter="openDropdown = true"
                                @mouseleave="openDropdown = false" class="relative">

                                <button class="inline-flex items-center gap-1 transition duration-200
                                            {{ $isParentActive
                        ? 'text-emerald-700 font-semibold'
                        : 'text-gray-700 hover:text-emerald-700' }}">

                                    {{ $menu['label'] }}

                                    <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': openDropdown }" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-cloak x-show="openDropdown" x-transition
                                    class="absolute left-0 mt-3 w-48 bg-white border border-gray-100 rounded-xl shadow-lg py-2">

                                    @foreach($menu['children'] as $child)

                                                @php
                                                    $childActive = request()->routeIs($child['active_pattern'] ?? $child['route']);
                                                @endphp

                                                <a href="{{ route($child['route']) }}" class="block px-4 py-2 text-sm transition
                                                                           {{ $childActive
                                        ? 'bg-emerald-50 text-emerald-700 font-medium'
                                        : 'text-gray-700 hover:bg-gray-100' }}">
                                                    {{ $child['label'] }}
                                                </a>

                                    @endforeach

                                </div>
                            </div>

                    @endif

                @endforeach


                {{-- AUTH SECTION --}}
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
            <nav class="flex flex-col px-6 py-4 space-y-2 text-sm font-medium">

                @foreach(config('public_navigation') as $menu)

                    @if(!isset($menu['children']))

                        <a href="{{ route($menu['route']) }}" class="py-2 text-gray-700 hover:text-emerald-700 transition">
                            {{ $menu['label'] }}
                        </a>

                    @else

                        <div x-data="{ openSub: false }" class="border-t pt-3">

                            <button @click="openSub = !openSub"
                                class="w-full flex justify-between items-center py-2 text-gray-700 hover:text-emerald-700 transition">

                                {{ $menu['label'] }}

                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': openSub }" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="openSub" x-transition class="pl-4 space-y-1 mt-2">

                                @foreach($menu['children'] as $child)
                                    <a href="{{ route($child['route']) }}"
                                        class="block py-1 text-gray-600 hover:text-emerald-700 transition">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach

                            </div>

                        </div>

                    @endif

                @endforeach


                {{-- AUTH SECTION --}}
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="pt-4 text-emerald-700 font-semibold">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="mt-4 inline-flex justify-center rounded-md bg-emerald-600 px-4 py-2 text-white">
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
@stack('scripts')
</body>

</html>