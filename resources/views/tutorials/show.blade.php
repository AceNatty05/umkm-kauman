<x-app-layout>
    <x-slot name="title">{{ $tutorial->title }} - Panduan UMKM Kauman</x-slot>

    <!-- Header Section -->
    <section class="hero-animated-gradient relative text-white py-10 overflow-hidden">
        <div class="hero-blob w-64 h-64 bg-kauman-primary-light/30 -top-16 -right-16" style="animation-delay: 1s;"></div>
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-4 flex items-center space-x-2">
                <a href="{{ route('public.tutorials.index') }}" class="text-green-100 hover:text-white transition-colors flex items-center text-sm font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Kembali ke Daftar
                </a>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold tracking-tight mb-3">{{ $tutorial->title }}</h1>
            <div class="flex items-center space-x-4 text-sm text-green-100/90">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $tutorial->created_at->translatedFormat('d F Y') }}
                </div>
                <div>
                    @if($tutorial->target_role == 'admin')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-500/20 text-red-100 border border-red-500/30">Khusus Admin</span>
                    @elseif($tutorial->target_role == 'user')
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-white/20 text-white border border-white/30">Panduan UMKM</span>
                    @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-500/20 text-gray-100 border border-gray-400/30">Umum</span>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-10 overflow-hidden">
            
            @if($tutorial->video_url)
                <div class="mb-8 rounded-xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50 aspect-video">
                    @php
                        // Coba ubah youtube watch url ke embed url
                        $embedUrl = $tutorial->video_url;
                        if (str_contains($tutorial->video_url, 'youtube.com/watch?v=')) {
                            $videoId = explode('v=', $tutorial->video_url)[1];
                            $videoId = explode('&', $videoId)[0];
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                        } elseif (str_contains($tutorial->video_url, 'youtu.be/')) {
                            $videoId = explode('youtu.be/', $tutorial->video_url)[1];
                            $videoId = explode('?', $videoId)[0];
                            $embedUrl = 'https://www.youtube.com/embed/' . $videoId;
                        }
                    @endphp
                    <iframe class="w-full h-full" src="{{ $embedUrl }}" title="Video Tutorial" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            @endif

            <div class="prose prose-olive max-w-none font-sans">
                {!! $tutorial->content !!}
            </div>

        </div>
    </div>
</x-app-layout>
