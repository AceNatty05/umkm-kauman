<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'UMKM Desa Kauman') }}</title>

    <!-- Canonical URL untuk SEO -->
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-kauman-body text-gray-800">
    <div class="min-h-screen flex flex-col items-center justify-center px-4 py-12">
        <!-- Logo -->
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center space-x-3">
                <div class="w-12 h-12 bg-kauman-primary rounded-full flex items-center justify-center">
                    <span class="text-white font-bold text-xl">DK</span>
                </div>
                <span class="text-2xl font-bold text-kauman-primary">UMKM Kauman</span>
            </a>
        </div>

        <!-- Card -->
        <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 border border-kauman-card-border/30">
            {{ $slot }}
        </div>
    </div>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
