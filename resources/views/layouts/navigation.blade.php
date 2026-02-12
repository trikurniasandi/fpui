<nav x-data="{ open: false }"
    class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Primary Navigation -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- Left Section -->
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center select-none group">
                        <span
                            class="text-3xl sm:text-4xl font-extrabold uppercase tracking-widest
                            text-gray-800 dark:text-emerald-600
                            group-hover:text-gray-200 transition">
                            FPUI|
                        </span>
                        <span
                            class="text-3xl sm:text-4xl font-bold uppercase tracking-wider
                            text-gray-800 dark:text-red-600
                            group-hover:text-gray-200 transition">
                            CMS
                        </span>
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-8">

                    @foreach(config('admin_navigation') as $menu)

                        {{-- Single Menu --}}
                        @if(!isset($menu['children']))

                            <x-nav-link
                                :href="route($menu['route'])"
                                :active="request()->routeIs($menu['active_pattern'] ?? $menu['route'])">
                                {{ $menu['label'] }}
                            </x-nav-link>

                        {{-- Dropdown Menu --}}
                        @else

                            @php
                                $isActive = collect($menu['children'])
                                    ->pluck('active_pattern')
                                    ->filter()
                                    ->contains(fn($pattern) => request()->routeIs($pattern));
                            @endphp

                            <x-dropdown align="left" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition
                                        {{ $isActive
                                            ? 'border-indigo-400 text-gray-900 dark:text-gray-100'
                                            : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 hover:border-gray-300' }}">
                                        {{ $menu['label'] }}
                                        <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @foreach($menu['children'] as $child)
                                        <x-dropdown-link :href="route($child['route'])">
                                            {{ $child['label'] }}
                                        </x-dropdown-link>
                                    @endforeach
                                </x-slot>
                            </x-dropdown>

                        @endif

                    @endforeach

                </div>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">

                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 text-sm font-medium rounded-md
                            text-gray-500 dark:text-gray-400
                            bg-white dark:bg-gray-800
                            hover:text-gray-700 dark:hover:text-gray-300
                            focus:outline-none transition">

                            <span>{{ Auth::user()->name }}</span>

                            <svg class="ms-1 h-4 w-4 fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('admin.profile.edit')">
                            Profile
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </x-slot>

                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = !open"
                    class="p-2 rounded-md text-gray-400 hover:text-gray-500
                    hover:bg-gray-100 dark:hover:bg-gray-900 transition">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }"
                            class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }"
                            class="hidden"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Navigation -->
    <div :class="{ 'block': open, 'hidden': !open }"
        class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            @foreach(config('admin_navigation') as $menu)

                @if(!isset($menu['children']))

                    <x-responsive-nav-link
                        :href="route($menu['route'])"
                        :active="request()->routeIs($menu['active_pattern'] ?? $menu['route'])">
                        {{ $menu['label'] }}
                    </x-responsive-nav-link>

                @else

                    <div class="px-4 py-2 text-xs font-semibold text-gray-400 uppercase">
                        {{ $menu['label'] }}
                    </div>

                    @foreach($menu['children'] as $child)
                        <x-responsive-nav-link
                            :href="route($child['route'])"
                            :active="request()->routeIs($child['active_pattern'] ?? $child['route'])">
                            {{ $child['label'] }}
                        </x-responsive-nav-link>
                    @endforeach

                @endif

            @endforeach

        </div>

        <!-- Mobile User Info -->
        <div class="border-t border-gray-200 dark:border-gray-600 pt-4 pb-1">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-sm text-gray-500">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('admin.profile.edit')">
                    Profile
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>

    </div>

</nav>