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
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-kauman-body text-gray-800">
    <!-- Navbar -->
    <nav class="bg-kauman-primary shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Left: Logo & Nav Links -->
                <div class="flex items-center space-x-8">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-white rounded-full flex items-center justify-center">
                            <span class="text-kauman-primary font-bold text-sm">DK</span>
                        </div>
                        <span class="text-white font-bold text-lg hidden sm:block">UMKM Kauman</span>
                    </a>

                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('home') }}"
                           class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('home') ? 'bg-kauman-primary-dark text-white' : 'text-green-100 hover:bg-kauman-primary-dark hover:text-white' }} transition-colors">
                            Beranda
                        </a>

                        @auth
                            <a href="{{ route('umkm.index') }}"
                               class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('umkm.*') && !request()->routeIs('umkm.show') ? 'bg-kauman-primary-dark text-white' : 'text-green-100 hover:bg-kauman-primary-dark hover:text-white' }} transition-colors">
                                Manajemen UMKM
                            </a>

                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('users.index') }}"
                                   class="px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('users.*') ? 'bg-kauman-primary-dark text-white' : 'text-green-100 hover:bg-kauman-primary-dark hover:text-white' }} transition-colors">
                                    Manajemen User
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                <!-- Right: Auth -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}"
                           class="text-green-100 hover:text-white text-sm hidden sm:block transition-colors">
                            Dashboard
                        </a>
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center space-x-2 text-green-100 hover:text-white transition-colors">
                                <img src="{{ auth()->user()->photo_url }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-green-300 object-cover">
                                <span class="hidden sm:block text-sm">{{ auth()->user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl py-1 z-50">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-olive-50">Profil Saya</a>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-olive-50">Dashboard</a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Keluar</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                           class="px-4 py-2 text-sm font-medium text-white bg-kauman-primary-dark rounded-lg hover:bg-olive-900 transition-colors border border-green-400/30">
                            Login / Daftar
                        </a>
                    @endauth

                    <!-- Mobile menu button -->
                    <button class="md:hidden text-green-100 hover:text-white" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-kauman-primary-dark pb-3">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-green-100 hover:text-white text-sm">Beranda</a>
            @auth
                <a href="{{ route('umkm.index') }}" class="block px-4 py-2 text-green-100 hover:text-white text-sm">Manajemen UMKM</a>
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('users.index') }}" class="block px-4 py-2 text-green-100 hover:text-white text-sm">Manajemen User</a>
                @endif
            @endauth
        </div>
    </nav>

    <!-- Flash Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition class="fixed top-20 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition class="fixed top-20 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg max-w-sm">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-kauman-primary text-green-100 mt-16">
        <div class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
            <div class="text-center">
                <p class="text-lg font-bold text-white mb-2">UMKM Desa Kauman</p>
                <p class="text-sm text-green-200">Portal UMKM untuk mendukung pertumbuhan usaha mikro, kecil, dan menengah di Desa Kauman.</p>
                <p class="text-xs text-green-300 mt-4">&copy; {{ date('Y') }} UMKM Desa Kauman. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
