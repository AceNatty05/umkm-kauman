<x-app-layout>
    <x-slot name="title">Detail {{ $umkm->name }} — UMKM Desa Kauman</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-400 mb-6 flex items-center gap-2">
            <a href="{{ route('home') }}" class="hover:text-kauman-primary transition-colors flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Beranda
            </a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-700 font-medium">{{ $umkm->name }}</span>
        </nav>

        <!-- Main Info -->
        <div class="bg-white rounded-2xl shadow-lg shadow-olive-200/30 overflow-hidden mb-8 border border-olive-100 reveal-on-scroll">
            <div class="img-zoom-container">
                <img src="{{ $umkm->photo }}" alt="{{ $umkm->name }}" class="w-full h-64 sm:h-80 object-cover">
            </div>
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-5">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2 tracking-tight">{{ $umkm->name }}</h1>
                        @if($umkm->category)
                            <span class="inline-flex items-center gap-1 text-sm bg-olive-100 text-olive-700 rounded-full px-3.5 py-1 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                                {{ $umkm->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="flex gap-2 shrink-0">
                        @if($umkm->whatsapp_link)
                        <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="btn-pill bg-[#25D366] text-white hover:bg-[#20bd5a]">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            WhatsApp
                        </a>
                        @endif
                        @if($umkm->location)
                        <a href="{{ $umkm->location }}" target="_blank" class="btn-pill bg-kauman-secondary text-white hover:bg-blue-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Lokasi
                        </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm mb-6">
                    <div class="flex items-center gap-3 bg-olive-50/70 rounded-xl px-4 py-3">
                        <div class="w-9 h-9 rounded-lg bg-olive-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Pemilik</p>
                            <p class="font-medium text-gray-700">{{ $umkm->owner_name }}</p>
                        </div>
                    </div>
                    @if($umkm->phone)
                    <div class="flex items-center gap-3 bg-olive-50/70 rounded-xl px-4 py-3">
                        <div class="w-9 h-9 rounded-lg bg-olive-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">WhatsApp</p>
                            <p class="font-medium text-gray-700">{{ $umkm->phone }}</p>
                        </div>
                    </div>
                    @endif
                    @if($umkm->operating_hours)
                    <div class="flex items-center gap-3 bg-olive-50/70 rounded-xl px-4 py-3">
                        <div class="w-9 h-9 rounded-lg bg-olive-100 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-olive-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-400 uppercase tracking-wider">Jam Buka</p>
                            <p class="font-medium text-gray-700">{{ $umkm->operating_hours }}</p>
                        </div>
                    </div>
                    @endif
                </div>

                <div class="prose max-w-none text-gray-600 leading-relaxed">
                    {!! nl2br(e($umkm->description)) !!}
                </div>
            </div>
        </div>

        <!-- Gallery -->
        @if($umkm->photos->count() > 0)
        <section class="mb-8 reveal-on-scroll">
            <div class="flex items-center gap-3 mb-5">
                <h2 class="text-2xl font-bold text-gray-800">Galeri Foto</h2>
                <div class="flex-1 h-px bg-gradient-to-r from-olive-200 to-transparent"></div>
            </div>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($umkm->photos as $photo)
                <div class="aspect-square rounded-xl overflow-hidden border border-olive-200/60 shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1 img-zoom-container cursor-pointer group">
                    <img src="{{ $photo->photo_path }}" alt="{{ $photo->caption ?? $umkm->name }}" class="w-full h-full object-cover" loading="lazy">
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Products -->
        @if($umkm->products->count() > 0)
        <section class="reveal-on-scroll">
            <div class="flex items-center gap-3 mb-5">
                <h2 class="text-2xl font-bold text-gray-800">Produk</h2>
                <span class="bg-olive-100 text-olive-700 text-sm font-semibold px-3 py-0.5 rounded-full">{{ $umkm->products->count() }}</span>
                <div class="flex-1 h-px bg-gradient-to-r from-olive-200 to-transparent"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($umkm->products as $i => $product)
                <div class="card-glow bg-white rounded-2xl border border-olive-200/60 shadow-sm overflow-hidden fade-up" style="animation-delay: {{ $i * 0.07 }}s">
                    <div class="img-zoom-container">
                        <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="w-full h-44 object-cover" loading="lazy">
                    </div>
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                        @if($product->formatted_price)
                            <p class="text-kauman-primary font-bold text-sm mb-2">{{ $product->formatted_price }}</p>
                        @endif
                        @if($product->description)
                            <p class="text-sm text-gray-500 line-clamp-2 leading-relaxed">{{ $product->description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-app-layout>
