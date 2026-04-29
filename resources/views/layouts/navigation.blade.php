<nav x-data="{ open: false }" class="bg-white border-b border-bloom-mint-light shadow-sm sticky top-0 z-40">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <div class="shrink-0 flex items-center">
                <a href="{{ route('products.index') }}" class="text-2xl font-bold text-bloom-teal hover:text-bloom-coral transition">
                    Bloomify
                </a>
            </div>

            <!-- Navigation Links (Desktop) -->
            <div class="hidden sm:flex items-center space-x-6">
                <!-- Beranda -->
                <a href="/" class="text-sm font-medium text-gray-900 hover:text-bloom-teal transition">
                    Beranda
                </a>

                <!-- Katalog -->
                <a href="{{ route('products.index') }}" class="text-sm font-medium {{ request()->routeIs('products.*') && !request()->routeIs('dashboard*') ? 'text-bloom-teal' : 'text-gray-900 hover:text-bloom-teal' }} transition">
                    Katalog
                </a>

                <!-- Dashboard/Admin Panel -->
                @auth
                    @if(Auth::user()->is_admin)
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-medium {{ request()->routeIs('admin.*') ? 'text-bloom-teal' : 'text-gray-900 hover:text-bloom-teal' }} transition">
                            Admin Panel
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-bloom-teal' : 'text-gray-900 hover:text-bloom-teal' }} transition">
                            Dashboard
                        </a>
                    @endif
                @endauth

                <!-- Auth Section -->
                @auth
                    <!-- Profile Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 px-2 py-1 text-sm font-medium text-gray-900 hover:text-bloom-teal transition">
                                <div class="w-8 h-8 bg-gradient-to-br from-bloom-teal to-bloom-coral rounded-full flex items-center justify-center text-white font-semibold text-xs overflow-hidden">
                                    @if(Auth::user()->profile_picture)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Profile" class="w-full h-full object-cover">
                                    @else
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    @endif
                                </div>
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(Auth::user()->is_admin)
                                <x-dropdown-link :href="route('admin.profile.edit')" class="text-gray-900">
                                    {{ __('Profil') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('profile.edit')" class="text-gray-900">
                                    {{ __('Profil') }}
                                </x-dropdown-link>
                            @endif

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="text-gray-900"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Logout') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Login & Daftar -->
                    <a href="{{ route('login') }}" class="text-sm font-medium text-bloom-teal hover:text-bloom-coral transition">Login</a>
                    <a href="{{ route('register') }}" class="text-sm font-medium text-bloom-coral hover:text-bloom-teal transition">Daftar</a>
                @endauth
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-bloom-teal hover:text-bloom-coral hover:bg-bloom-cream focus:outline-none focus:bg-bloom-cream focus:text-bloom-coral transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div x-show="open" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                {{ __('Beranda') }}
            </a>
            <a href="{{ route('products.index') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                {{ __('Katalog') }}
            </a>
            @auth
            @if(Auth::user()->is_admin)
                <a href="{{ route('admin.dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                    {{ __('Admin Panel') }}
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                    {{ __('Dashboard') }}
                </a>
            @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-bloom-mint-light">
            <div class="px-4">
                <div class="font-medium text-base text-bloom-teal">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-700">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(Auth::user()->is_admin)
                    <a href="{{ route('admin.profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                        {{ __('Profil') }}
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                        {{ __('Profil') }}
                    </a>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-gray-900 hover:text-bloom-teal hover:bg-bloom-cream transition">
                        {{ __('Logout') }}
                    </button>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-bloom-mint-light">
            <div class="px-4 space-y-2">
                <a href="{{ route('login') }}" class="block text-bloom-teal hover:text-bloom-coral font-medium py-2">Login</a>
                <a href="{{ route('register') }}" class="block text-bloom-coral hover:text-bloom-teal font-medium py-2">Daftar</a>
            </div>
        </div>
        @endauth
    </div>
</nav>
