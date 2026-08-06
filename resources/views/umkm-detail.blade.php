<x-app-layout>
    <x-slot name="title">Detail {{ $umkm->name }} — UMKM Desa Kauman</x-slot>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-kauman-primary">Beranda</a>
            <span class="mx-2">/</span>
            <span class="text-gray-800">{{ $umkm->name }}</span>
        </nav>

        <!-- Main Info -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden mb-8">
            <img src="{{ $umkm->photo }}" alt="{{ $umkm->name }}" class="w-full h-64 sm:h-80 object-cover">
            <div class="p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $umkm->name }}</h1>
                        @if($umkm->category)
                            <span class="inline-block text-sm bg-olive-100 text-olive-700 rounded-full px-3 py-1">{{ $umkm->category->name }}</span>
                        @endif
                    </div>
                    <div class="flex gap-2 shrink-0">
                        @if($umkm->whatsapp_link)
                        <a href="{{ $umkm->whatsapp_link }}" target="_blank" class="flex items-center gap-2 bg-kauman-whatsapp text-white px-5 py-2.5 rounded-lg font-medium hover:opacity-90 transition-opacity">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            WhatsApp
                        </a>
                        @endif
                        @if($umkm->location)
                        <a href="{{ $umkm->location }}" target="_blank" class="flex items-center gap-2 bg-kauman-secondary text-white px-5 py-2.5 rounded-lg font-medium hover:opacity-90 transition-opacity">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            Lokasi
                        </a>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-600 mb-6">
                    <div><strong class="text-gray-800">Pemilik:</strong> {{ $umkm->owner_name }}</div>
                    @if($umkm->phone)<div><strong class="text-gray-800">WhatsApp:</strong> {{ $umkm->phone }}</div>@endif
                    @if($umkm->operating_hours)<div><strong class="text-gray-800">Jam Buka:</strong> {{ $umkm->operating_hours }}</div>@endif
                </div>

                <div class="prose max-w-none text-gray-700">
                    {!! nl2br(e($umkm->description)) !!}
                </div>
            </div>
        </div>

        <!-- Gallery -->
        @if($umkm->photos->count() > 0)
        <section class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Galeri Foto</h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
                @foreach($umkm->photos as $photo)
                <div class="aspect-square rounded-xl overflow-hidden border border-kauman-card-border shadow-sm hover:shadow-md transition-shadow">
                    <img src="{{ $photo->photo_path }}" alt="{{ $photo->caption ?? $umkm->name }}" class="w-full h-full object-cover">
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Products -->
        @if($umkm->products->count() > 0)
        <section>
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Produk ({{ $umkm->products->count() }})</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($umkm->products as $product)
                <div class="bg-kauman-card rounded-xl border border-kauman-card-border shadow-sm">
                    <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="w-full h-44 object-cover rounded-t-xl">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $product->name }}</h3>
                        @if($product->formatted_price)
                            <p class="text-kauman-primary font-bold text-sm mb-2">{{ $product->formatted_price }}</p>
                        @endif
                        @if($product->description)
                            <p class="text-sm text-gray-500 line-clamp-2">{{ $product->description }}</p>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</x-app-layout>
