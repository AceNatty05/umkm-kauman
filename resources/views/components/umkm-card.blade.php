<div class="bg-white rounded-2xl border border-kauman-card-border shadow-sm overflow-hidden flex flex-col h-full hover:shadow-md transition-shadow">
    <!-- UMKM Gallery Header -->
    <div class="relative w-full h-56 sm:h-64 bg-gray-100 flex overflow-x-auto snap-x snap-mandatory" style="scrollbar-width: thin;">
        <!-- Main Photo -->
        <div class="w-full h-full flex-shrink-0 snap-start relative group">
            <img src="{{ $umkm->photo }}" alt="{{ $umkm->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 p-4 text-white w-full pointer-events-none">
                <h3 class="text-xl font-bold truncate mb-1" title="{{ $umkm->name }}">{{ $umkm->name }}</h3>
                @if($umkm->category)
                <span class="inline-block px-2.5 py-0.5 bg-kauman-primary rounded-full text-xs font-medium">{{ $umkm->category->name }}</span>
                @endif
            </div>
        </div>
        <!-- Additional Gallery Photos -->
        @foreach($umkm->photos as $galleryPhoto)
        <div class="w-full h-full flex-shrink-0 snap-start relative">
            <img src="{{ $galleryPhoto->photo_path }}" alt="Gallery of {{ $umkm->name }}" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 p-4 text-white w-full pointer-events-none">
                <h3 class="text-xl font-bold truncate mb-1" title="{{ $umkm->name }}">{{ $umkm->name }}</h3>
                @if($umkm->category)
                <span class="inline-block px-2.5 py-0.5 bg-kauman-primary rounded-full text-xs font-medium">{{ $umkm->category->name }}</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <!-- UMKM Info -->
    <div class="p-5 flex-1 flex flex-col">
        <p class="text-sm text-gray-600 line-clamp-2 mb-4 flex-1" title="{{ $umkm->description }}">{{ $umkm->description }}</p>
        
        <div class="grid grid-cols-2 gap-3 mb-4">
            @if($umkm->operating_hours)
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-4 h-4 mr-1.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span class="truncate">{{ $umkm->operating_hours }}</span>
            </div>
            @endif
            @if($umkm->owner_name)
            <div class="flex items-center text-xs text-gray-500">
                <svg class="w-4 h-4 mr-1.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span class="truncate">{{ $umkm->owner_name }}</span>
            </div>
            @endif
        </div>

        <div class="flex gap-2">
            @if($umkm->whatsapp_link)
            <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="flex-1 flex justify-center items-center gap-1.5 text-sm font-medium bg-[#25D366] text-white rounded-lg px-3 py-2 hover:bg-[#20bd5a] transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                WhatsApp
            </a>
            @endif
            @if($umkm->location)
            <a href="{{ $umkm->location }}" target="_blank" class="flex-1 flex justify-center items-center gap-1.5 text-sm font-medium bg-blue-600 text-white rounded-lg px-3 py-2 hover:bg-blue-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Lokasi
            </a>
            @endif
            <a href="{{ route('public.umkm.show', $umkm->slug) }}" class="flex-none flex justify-center items-center gap-1 text-sm font-medium border border-gray-300 text-gray-700 rounded-lg px-3 py-2 hover:bg-gray-50 transition-colors" title="Lihat Profil">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            </a>
        </div>
    </div>

    <!-- Products List (Bottom Section) -->
    @if($umkm->products->count() > 0)
    <div class="border-t border-kauman-card-border bg-gray-50/50 p-4">
        <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Daftar Produk</h4>
        <div class="flex overflow-x-auto gap-3 pb-2 -mx-4 px-4 snap-x snap-mandatory" style="scrollbar-width: thin;">
            @foreach($umkm->products as $prod)
            <div class="snap-start flex-shrink-0 w-36 bg-white rounded-lg border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
                <div class="w-full h-28 overflow-hidden bg-gray-100">
                    <img src="{{ $prod->photo }}" alt="{{ $prod->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-2.5">
                    <p class="text-xs font-medium text-gray-800 truncate mb-1" title="{{ $prod->name }}">{{ $prod->name }}</p>
                    @if($prod->formatted_price)
                    <p class="text-[11px] font-bold text-kauman-primary truncate">{{ $prod->formatted_price }}</p>
                    @else
                    <p class="text-[11px] font-medium text-gray-400 italic">Harga tidak tersedia</p>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
