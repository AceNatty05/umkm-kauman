<x-app-layout>
    <x-slot name="title">Tutorial & Panduan UMKM Kauman</x-slot>

    <!-- Header Section -->
    <section class="hero-animated-gradient relative text-white py-12 sm:py-16 overflow-hidden">
        <div class="hero-blob w-64 h-64 bg-kauman-primary-light/30 -top-16 -right-16" style="animation-delay: 1s;"></div>
        <div class="hero-blob w-48 h-48 bg-olive-400/20 bottom-0 left-1/4" style="animation-delay: 4s;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Tutorial & Panduan</h1>
            <p class="mt-3 text-green-100/80 text-lg max-w-xl mx-auto">Pelajari cara menggunakan portal UMKM Desa Kauman dan dapatkan tips bermanfaat lainnya.</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if($tutorials->isEmpty())
            <div class="text-center text-gray-500 py-16 bg-white rounded-2xl shadow-sm border border-olive-100">
                <div class="w-16 h-16 mx-auto bg-olive-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="font-medium text-gray-600">Belum ada tutorial yang ditambahkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($tutorials as $i => $tutorial)
                    <a href="{{ route('public.tutorials.show', $tutorial->slug) }}" class="block group fade-up" style="animation-delay: {{ $i * 0.1 }}s">
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 group-hover:shadow-md transition-all duration-300 group-hover:border-kauman-primary/30 h-full flex flex-col">
                            <div class="flex items-start justify-between mb-4">
                                @if($tutorial->target_role == 'admin')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        Khusus Admin
                                    </span>
                                @elseif($tutorial->target_role == 'user')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-kauman-primary/10 text-kauman-primary-dark">
                                        Panduan UMKM
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Umum
                                    </span>
                                @endif
                                
                                <span class="text-xs text-gray-400">{{ $tutorial->created_at->translatedFormat('d M Y') }}</span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-gray-900 group-hover:text-kauman-primary transition-colors mb-2 line-clamp-2">
                                {{ $tutorial->title }}
                            </h3>
                            
                            <p class="text-gray-500 text-sm mb-4 line-clamp-3 flex-grow">
                                {{ Str::limit(strip_tags($tutorial->content), 120) }}
                            </p>
                            
                            <div class="flex items-center text-sm font-medium text-kauman-primary group-hover:text-kauman-primary-dark mt-auto">
                                Baca selengkapnya
                                <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $tutorials->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
