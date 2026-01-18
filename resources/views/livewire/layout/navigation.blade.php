<header 
    x-data="{ mobileMenuOpen: false, scrolled: false }"
    @scroll.window="scrolled = (window.pageYOffset > 10)"
    class="sticky top-0 z-50 w-full bg-white bg-opacity-100 border-b border-gray-200"
    :class="{ 'shadow-md': scrolled, 'shadow-sm': !scrolled }"
>
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            {{-- LOGO SECTION --}}
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 transition-opacity hover:opacity-80">
                    <img src="{{ asset('image/logo.jpeg') }}" 
                        alt="Islamic Adventure Logo" 
                        class="h-11 w-auto rounded-lg object-cover shadow-sm group-hover:shadow-md transition-all duration-300">
                        
                    <div class="flex flex-col">
                        <span class="text-xl font-bold tracking-tight text-gray-900">
                            Islamic<span class="text-primary-600">Adventure</span>
                        </span>
                    </div> 
                </a>
            </div>

            {{-- DESKTOP MENU LINKS --}}
            <div class="hidden md:flex items-center gap-1 p-1 bg-gray-50 rounded-full border border-gray-100">
                <a href="{{ route('home') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('home') ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-200/50' }}">
                    Beranda
                </a>
                <a href="{{ route('mountains.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('mountains.*') ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-200/50' }}">
                    Gunung
                </a>
                <a href="{{ route('packages.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('packages.*') ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-200/50' }}">
                    Paket
                </a>
                <a href="{{ route('equipment.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('equipment.*') ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-200/50' }}">
                    Peralatan
                </a>
                @auth
                <a href="{{ route('user.bookings.history') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-300 {{ request()->routeIs('bookings.*') ? 'bg-white text-primary-600 shadow-sm ring-1 ring-gray-200' : 'text-gray-600 hover:text-primary-600 hover:bg-gray-200/50' }}">
                    Pesanan
                </a>
                @endauth
            </div>

            {{-- RIGHT SIDE ACTIONS --}}
            <div class="flex items-center gap-3">
                
                {{-- [BARU] TOMBOL KERANJANG (DESKTOP) --}}
                <a href="{{ route('booking.cart') }}" 
                   class="hidden md:flex relative p-2 text-gray-600 hover:text-primary-600 hover:bg-gray-100 rounded-full transition-all duration-300 group {{ request()->routeIs('booking.cart') ? 'text-primary-600 bg-primary-50' : '' }}"
                   title="Keranjang Belanja">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{-- Opsi: Badge Indikator jika ada item (Bisa diaktifkan jika ada variabel count) --}}
                    {{-- <span class="absolute top-1 right-1 h-2.5 w-2.5 bg-red-500 rounded-full border border-white"></span> --}}
                </a>

                @guest
                    <a href="{{ route('login') }}" 
                       class="hidden md:inline-flex items-center px-5 py-2.5 text-sm font-medium text-gray-700 hover:text-primary-600 transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-900 text-white text-sm font-medium rounded-full hover:bg-primary-600 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">
                        Daftar
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                @else
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" 
                                @click.away="open = false"
                                class="flex items-center gap-3 focus:outline-none group p-1 pl-3 pr-1 rounded-full border border-gray-100 hover:border-primary-100 hover:bg-primary-50 transition-all duration-300">
                            <div class="hidden md:block text-right">
                                <div class="text-xs font-semibold text-gray-900 leading-tight">{{ auth()->user()->name }}</div>
                            </div>
                            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-primary-500 to-indigo-600 flex items-center justify-center text-white text-sm font-bold shadow-md ring-2 ring-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-gray-400 group-hover:text-primary-500 transition-transform mr-1" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>

                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="absolute right-0 mt-3 w-64 bg-white bg-opacity-100 rounded-2xl shadow-xl border border-gray-100 py-2 z-50"
                             style="display: none;">
                            
                            <div class="px-5 py-4 bg-gray-50 border-b border-gray-100">
                                <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="p-2 space-y-1">
                                <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 rounded-xl hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                @if(auth()->user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 rounded-xl hover:bg-primary-50 hover:text-primary-700 transition-colors">
                                    <svg class="w-4 h-4 mr-3 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                    Dashboard Admin
                                </a>
                                @endif
                            </div>
                            <div class="p-2 border-t border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center px-4 py-2.5 text-sm font-medium text-red-600 rounded-xl hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endguest

                {{-- MOBILE MENU BUTTON --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" 
                        class="md:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- MOBILE MENU DROPDOWN --}}
        <div x-show="mobileMenuOpen" 
             style="display: none;"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-4"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-4"
             class="md:hidden absolute top-20 left-0 w-full bg-white bg-opacity-100 border-b border-gray-200 shadow-xl z-40">
            
            <div class="px-4 py-6 space-y-3 bg-white">
                <a href="{{ route('home') }}" class="block px-4 py-3 rounded-xl text-base font-medium transition-colors {{ request()->routeIs('home') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    Beranda
                </a>
                <a href="{{ route('mountains.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium transition-colors {{ request()->routeIs('mountains.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    Gunung
                </a>

                <a href="{{ route('packages.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium transition-colors {{ request()->routeIs('packages.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    Paket
                </a>
                <a href="{{ route('equipment.index') }}" class="block px-4 py-3 rounded-xl text-base font-medium transition-colors {{ request()->routeIs('equipment.*') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    Peralatan
                </a>

                {{-- [BARU] MENU KERANJANG (MOBILE) --}}
                <a href="{{ route('booking.cart') }}" class="flex items-center justify-between px-4 py-3 rounded-xl text-base font-medium transition-colors {{ request()->routeIs('booking.cart') ? 'bg-primary-50 text-primary-700' : 'text-gray-600 hover:bg-gray-50' }}">
                    <span>Keranjang</span>
                    <svg class="w-5 h-5 opacity-70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </a>

                @auth
                <div class="border-t border-gray-100 my-2 pt-2"></div>
                <a href="{{ route('user.bookings.history') }}" class="block px-4 py-3 rounded-xl text-base font-medium text-gray-600 hover:bg-gray-50">
                    Pesanan Saya
                </a>
                @endauth
            </div>
        </div>
    </nav>
</header>