<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Portal UMKM Desa Kauman — Temukan produk dan usaha mikro kecil menengah terbaik dari Desa Kauman.">

    <title>{{ $title ?? config('app.name', 'UMKM Desa Kauman') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-kauman-body text-gray-800 flex flex-col min-h-screen" x-data="{ mobileOpen: false }">

    <!-- ==================== NAVBAR ==================== -->
    <nav class="navbar-glass sticky top-0 z-50" x-data="navbar()" x-init="init()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo & Nav Links -->
                <div class="flex items-center space-x-6 lg:space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2.5 group">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-10 h-10 rounded-full object-cover ring-2 ring-white/30 group-hover:ring-white/60 transition-all duration-300">
                        <span class="text-white font-bold text-lg hidden sm:block tracking-tight">UMKM Kauman</span>
                    </a>

                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('home') }}"
                           class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('home') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                            Beranda
                        </a>
                        <a href="{{ route('public.infografis.index') }}"
                           class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('public.infografis.*') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                            Infografis
                        </a>

                        @auth
                            <a href="{{ route('umkm.index') }}"
                               class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('umkm.*') && !request()->routeIs('umkm.show') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                                Manajemen UMKM
                            </a>
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('users.index') }}"
                                   class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                                    Manajemen User
                                </a>
                                <a href="{{ route('manage.infografis.index') }}"
                                   class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('manage.infografis.*') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                                    Manajemen Infografis
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right: Auth -->
                <div class="flex items-center space-x-3">
                    @auth
                        @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}"
                           class="text-green-100/80 hover:text-white text-sm hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-full hover:bg-white/10 transition-all duration-300">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            Dashboard
                        </a>
                        @endif
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-green-100 hover:text-white transition-colors rounded-full py-1 px-1 hover:bg-white/10">
                                <img src="{{ auth()->user()->photo_url }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-white/40 object-cover">
                                <span class="hidden sm:block text-sm font-medium">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="open && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
                                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute right-0 mt-2.5 w-52 bg-white rounded-xl shadow-xl ring-1 ring-black/5 py-1.5 z-50 overflow-hidden">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-olive-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Profil Saya
                                </a>
                                @if(auth()->user()->isAdmin())
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-olive-50 transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z"/></svg>
                                    Dashboard
                                </a>
                                @endif
                                <hr class="my-1.5 border-gray-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth

                    <!-- Mobile menu button -->
                    <button class="md:hidden text-green-100 hover:text-white p-1.5 rounded-lg hover:bg-white/10 transition-colors" @click="mobileOpen = !mobileOpen">
                        <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                        <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileOpen" x-cloak
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-kauman-primary-dark/95 backdrop-blur-lg pb-4 border-t border-white/10">
            <a href="{{ route('home') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Beranda</a>
            <a href="{{ route('public.infografis.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Infografis</a>
            @auth
                <a href="{{ route('umkm.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen UMKM</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen User</a>
                    <a href="{{ route('manage.infografis.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen Infografis</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- ==================== FLASH MESSAGES ==================== -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="fixed top-20 right-4 z-50 bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3.5 rounded-xl shadow-lg shadow-green-500/20 flex items-center space-x-2.5 backdrop-blur-sm">
            <div class="w-8 h-8 bg-white/20 rounded-full flex items-center justify-center shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-8"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0 translate-x-8"
             class="fixed top-20 right-4 z-50 bg-gradient-to-r from-red-500 to-rose-600 text-white px-6 py-3.5 rounded-xl shadow-lg shadow-red-500/20 max-w-sm backdrop-blur-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- ==================== PAGE CONTENT ==================== -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- ==================== FOOTER ==================== -->
    <footer class="relative bg-gradient-to-b from-kauman-primary to-kauman-primary-dark text-green-100 mt-16 overflow-hidden">
        <!-- Decorative top edge -->
        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-kauman-primary-light via-kauman-accent to-kauman-primary-light opacity-60"></div>

        <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center">
                <p class="text-xl font-bold text-white mb-1 tracking-tight">UMKM Desa Kauman</p>
                <p class="text-xs text-green-300/80 mt-3">&copy; KKN UNDIP TIM II 2026 Desa Kauman. All rights reserved.</p>

                <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 mt-6">
                    <img src="{{ asset('images/logo_kkn.png') }}" alt="Logo KKN" class="h-12 md:h-16 lg:h-20 w-auto rounded-full opacity-90 hover:opacity-100 transition-opacity duration-300">
                    <img src="{{ asset('images/logo_undip_horizontal.png') }}" alt="Logo Undip" class="h-16 md:h-24 lg:h-32 w-auto opacity-90 hover:opacity-100 transition-opacity duration-300">
                    <img src="{{ asset('images/logo_dikti_horizontal.png') }}" alt="Logo Dikti" class="h-16 md:h-24 lg:h-32 w-auto opacity-90 hover:opacity-100 transition-opacity duration-300">
                </div>
            </div>
        </div>
    </footer>

    <!-- ==================== SCRIPTS ==================== -->
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        // Navbar scroll effect
        function navbar() {
            return {
                scrolled: false,
                init() {
                    this.onScroll();
                    window.addEventListener('scroll', () => this.onScroll(), { passive: true });
                },
                onScroll() {
                    this.scrolled = window.scrollY > 20;
                    const nav = this.$el;
                    if (this.scrolled) {
                        nav.classList.add('scrolled');
                    } else {
                        nav.classList.remove('scrolled');
                    }
                }
            }
        }

        // Scroll-reveal observer
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

            document.querySelectorAll('.reveal-on-scroll').forEach(el => observer.observe(el));
        });
    </script>
</body>
</html>
