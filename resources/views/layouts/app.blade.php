<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Portal UMKM Desa Kauman — Temukan produk dan usaha mikro kecil menengah terbaik dari Desa Kauman.">

    <title>{{ $title ?? config('app.name', 'UMKM Desa Kauman') }}</title>

    <!-- Canonical URL untuk SEO -->
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

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
                        <a href="{{ route('public.tutorials.index') }}"
                           class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('public.tutorials.*') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                            Tutorial
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
                                <a href="{{ route('manage.tutorials.index') }}"
                                   class="px-3.5 py-2 rounded-full text-sm font-medium {{ request()->routeIs('manage.tutorials.*') ? 'bg-white/20 text-white shadow-inner' : 'text-green-100/80 hover:bg-white/10 hover:text-white' }} transition-all duration-300">
                                    Manajemen Tutorial
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
            <a href="{{ route('public.tutorials.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Tutorial</a>
            @auth
                <a href="{{ route('umkm.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen UMKM</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen User</a>
                    <a href="{{ route('manage.infografis.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen Infografis</a>
                    <a href="{{ route('manage.tutorials.index') }}" class="block px-5 py-2.5 text-green-100 hover:text-white hover:bg-white/10 text-sm transition-colors">Manajemen Tutorial</a>
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

        <div class="max-w-7xl mx-auto px-4 pt-12 pb-8 sm:px-6 lg:px-8 relative z-10">
            <!-- Main Footer Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10 md:gap-8 mb-10">

                <!-- Column 1: About -->
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <img src="{{ asset('favicon.ico') }}" alt="Logo" class="w-9 h-9 rounded-full ring-2 ring-white/20">
                        <h3 class="text-white font-bold text-lg tracking-tight">UMKM Desa Kauman</h3>
                    </div>
                    <p class="text-green-200/70 text-sm leading-relaxed">
                        Platform digital untuk mengenalkan dan mempromosikan produk UMKM Desa Kauman, Kec. Comal , Kab. Pemalang. Dikembangkan oleh Tim KKN UNDIP 2026.
                    </p>
                </div>

                <!-- Column 2: Navigasi -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Navigasi</h3>
                    <ul class="space-y-2.5">
                        <li>
                            <a href="{{ route('home') }}" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2 transition-colors duration-200 group">
                                <svg class="w-3.5 h-3.5 text-green-300/50 group-hover:text-kauman-primary-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home', ['tab' => 'produk']) }}#katalog" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2 transition-colors duration-200 group">
                                <svg class="w-3.5 h-3.5 text-green-300/50 group-hover:text-kauman-primary-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Katalog Produk
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home', ['tab' => 'umkm']) }}#katalog" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2 transition-colors duration-200 group">
                                <svg class="w-3.5 h-3.5 text-green-300/50 group-hover:text-kauman-primary-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Daftar UMKM
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.infografis.index') }}" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2 transition-colors duration-200 group">
                                <svg class="w-3.5 h-3.5 text-green-300/50 group-hover:text-kauman-primary-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Infografis
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('public.tutorials.index') }}" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2 transition-colors duration-200 group">
                                <svg class="w-3.5 h-3.5 text-green-300/50 group-hover:text-kauman-primary-light transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                Tutorial & Panduan
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Column 3: Kontak -->
                <div>
                    <h3 class="text-white font-semibold text-sm uppercase tracking-wider mb-4">Hubungi Kami</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="https://instagram.com/umkm.desakauman" target="_blank" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2.5 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white text-xs font-medium">Instagram UMKM</span>
                                    <span class="text-xs text-green-300/60">@umkm.desakauman</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://instagram.com/pemdeskauman" target="_blank" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2.5 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white text-xs font-medium">Instagram Pemdes</span>
                                    <span class="text-xs text-green-300/60">@pemdeskauman</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/6281234567890" target="_blank" class="text-green-200/70 hover:text-white text-sm flex items-center gap-2.5 transition-colors duration-200 group">
                                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                                </div>
                                <div>
                                    <span class="block text-white text-xs font-medium">WhatsApp Admin</span>
                                    <span class="text-xs text-green-300/60">+62 822-4300-9527</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-white/10 pt-8">
                <!-- Partner Logos -->
                <div class="flex flex-wrap justify-center items-center gap-4 md:gap-6 mb-6">
                    <img src="{{ asset('images/logo_kkn.png') }}" alt="Logo KKN" class="h-10 md:h-14 lg:h-16 w-auto rounded-full opacity-80 hover:opacity-100 transition-opacity duration-300">
                    <img src="{{ asset('images/logo_undip_horizontal.png') }}" alt="Logo Undip" class="h-14 md:h-20 lg:h-24 w-auto opacity-80 hover:opacity-100 transition-opacity duration-300">
                    <img src="{{ asset('images/logo_dikti_horizontal.png') }}" alt="Logo Dikti" class="h-14 md:h-20 lg:h-24 w-auto opacity-80 hover:opacity-100 transition-opacity duration-300">
                </div>

                <!-- Copyright -->
                <p class="text-center text-xs text-green-300/50">&copy; {{ date('Y') }} KKN UNDIP TIM II — Desa Kauman, Kec. Comal, Kab. Pemalang. All rights reserved.</p>
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
