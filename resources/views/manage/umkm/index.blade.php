<x-app-layout>
    <x-slot name="title">Manajemen UMKM — UMKM Desa Kauman</x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen UMKM</h1>
            <a href="{{ route('umkm.create') }}" class="bg-kauman-primary text-white px-5 py-2.5 rounded-lg font-medium hover:bg-kauman-primary-dark transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah UMKM
            </a>
        </div>

        <!-- Search & Tabs -->
        <form method="GET" action="{{ route('umkm.index') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
            <div class="flex rounded-lg overflow-hidden border border-kauman-card-border shrink-0">
                <a href="{{ route('umkm.index', ['tab' => 'produk', 'search' => $search]) }}" class="px-4 py-2 text-sm font-medium {{ $tab === 'produk' ? 'bg-kauman-primary text-white' : 'bg-white text-gray-700 hover:bg-olive-50' }} transition-colors">Produk</a>
                <a href="{{ route('umkm.index', ['tab' => 'umkm', 'search' => $search]) }}" class="px-4 py-2 text-sm font-medium {{ $tab === 'umkm' ? 'bg-kauman-primary text-white' : 'bg-white text-gray-700 hover:bg-olive-50' }} transition-colors">UMKM</a>
            </div>
            <div class="flex-1 flex gap-2">
                <input type="hidden" name="tab" value="{{ $tab }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari..." class="flex-1 rounded-lg border-kauman-card-border text-sm focus:ring-kauman-primary focus:border-kauman-primary">
                <button type="submit" class="bg-kauman-primary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary-dark transition-colors">Cari</button>
            </div>
        </form>

        <!-- Content Grid -->
        @if($tab === 'produk' && $products && $products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($products as $product)
            <div class="bg-kauman-card rounded-xl border border-kauman-card-border shadow-sm hover:shadow-lg transition-all duration-300">
                <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="w-full h-44 object-cover rounded-t-xl">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $product->name }}</h3>
                    <p class="text-sm text-gray-500 mb-1 truncate">{{ $product->umkm->name }}</p>
                    @if($product->formatted_price)<p class="text-kauman-primary font-bold text-sm mb-3">{{ $product->formatted_price }}</p>@endif
                    <div class="flex gap-1.5 flex-wrap">
                        <a href="{{ route('products.edit', [$product->umkm, $product]) }}" class="text-xs font-medium bg-green-500 text-white rounded px-2.5 py-1.5 hover:bg-green-600 transition-colors">Edit</a>
                        <form method="POST" action="{{ route('products.toggle-star', [$product->umkm, $product]) }}">@csrf @method('PATCH')
                            <button type="submit" class="text-xs font-medium {{ $product->is_starred ? 'bg-yellow-500' : 'bg-yellow-400' }} text-white rounded px-2.5 py-1.5 hover:bg-yellow-600 transition-colors">{{ $product->is_starred ? '★ Unggulan' : 'Iklankan' }}</button>
                        </form>
                        <form method="POST" action="{{ route('products.destroy', [$product->umkm, $product]) }}" onsubmit="return confirm('Hapus produk ini?')">@csrf @method('DELETE')
                            <button type="submit" class="text-xs font-medium bg-red-500 text-white rounded px-2.5 py-1.5 hover:bg-red-600 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $products->links() }}</div>
        @elseif($tab === 'umkm' && $umkms->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach($umkms as $umkm)
            <div class="bg-kauman-card rounded-xl border border-kauman-card-border shadow-sm hover:shadow-lg transition-all duration-300">
                <img src="{{ $umkm->photo }}" alt="{{ $umkm->name }}" class="w-full h-44 object-cover rounded-t-xl">
                <div class="p-4">
                    <h3 class="font-semibold text-gray-800 mb-1 truncate">{{ $umkm->name }}</h3>
                    @if($umkm->category)<span class="inline-block text-xs bg-olive-100 text-olive-700 rounded-full px-2 py-0.5 mb-2">{{ $umkm->category->name }}</span>@endif
                    @if($umkm->products->count() > 0)
                    <div class="flex gap-1 mb-3">
                        @foreach($umkm->products->take(3) as $prod)
                        <div class="w-10 h-10 rounded border border-kauman-card-border overflow-hidden shrink-0"><img src="{{ $prod->photo }}" class="w-full h-full object-cover"></div>
                        @endforeach
                    </div>
                    @endif
                    <div class="flex gap-1.5 flex-wrap">
                        <a href="{{ route('umkm.edit', $umkm) }}" class="text-xs font-medium bg-green-500 text-white rounded px-2.5 py-1.5 hover:bg-green-600 transition-colors">Edit</a>
                        <form method="POST" action="{{ route('umkm.destroy', $umkm) }}" onsubmit="return confirm('Hapus UMKM ini?')">@csrf @method('DELETE')
                            <button type="submit" class="text-xs font-medium bg-red-500 text-white rounded px-2.5 py-1.5 hover:bg-red-600 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $umkms->links() }}</div>
        @else
        <div class="text-center py-16"><p class="text-gray-500 text-lg">Belum ada data.</p></div>
        @endif
    </div>
</x-app-layout>
