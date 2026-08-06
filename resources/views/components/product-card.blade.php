@php $isStarred = $starred ?? false; @endphp
<div class="{{ $isStarred ? 'min-w-[260px] max-w-[280px] snap-start flex-shrink-0' : '' }} bg-kauman-card rounded-xl border border-kauman-card-border shadow-sm hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
    <a href="{{ route('umkm.show', $product->umkm->slug) }}">
        <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="w-full h-44 object-cover rounded-t-xl">
    </a>
    <div class="p-4">
        <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $product->name }}</h3>
        <p class="text-sm text-gray-500 mb-1 truncate">{{ $product->umkm->name }}</p>
        @if($product->formatted_price)
            <p class="text-kauman-primary font-bold text-sm mb-3">{{ $product->formatted_price }}</p>
        @else
            <div class="mb-3"></div>
        @endif
        <div class="flex gap-2">
            @if($product->umkm->whatsapp_link)
            <a href="{{ $product->umkm->whatsapp_link }}" target="_blank" class="flex-1 flex items-center justify-center gap-1 text-xs font-medium bg-kauman-whatsapp text-white rounded-lg px-3 py-2 hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                WhatsApp
            </a>
            @endif
            @if($product->umkm->location)
            <a href="{{ $product->umkm->location }}" target="_blank" class="flex-1 flex items-center justify-center gap-1 text-xs font-medium bg-kauman-secondary text-white rounded-lg px-3 py-2 hover:opacity-90 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Lokasi
            </a>
            @endif
        </div>
    </div>
</div>
