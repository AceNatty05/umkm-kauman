<x-app-layout>
    <x-slot name="title">UMKM Desa Kauman — Beranda</x-slot>

    <!-- Hero -->
    <section class="bg-gradient-to-br from-kauman-primary via-olive-700 to-kauman-primary-dark text-white py-12 sm:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold mb-4">UMKM Desa Kauman</h1>
            <p class="text-lg sm:text-xl text-green-100 max-w-2xl mx-auto">Temukan produk dan usaha terbaik dari Desa Kauman. Dukung UMKM lokal!</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @if($starredProducts->count() > 0)
        <section class="mb-10">
            <h2 class="text-2xl font-bold text-kauman-primary mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                Produk Unggulan
            </h2>
            <div class="flex overflow-x-auto gap-4 pb-4 -mx-4 px-4 snap-x snap-mandatory" style="scrollbar-width:thin;">
                @foreach($starredProducts as $product)
                @include('components.product-card', ['product' => $product, 'starred' => true])
                @endforeach
            </div>
        </section>
        @endif

        <!-- Search & Tabs -->
        <section class="mb-8">
            <form method="GET" action="{{ route('home') }}" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                <div class="flex rounded-lg overflow-hidden border border-kauman-card-border shrink-0">
                    <a href="{{ route('home', ['tab' => 'produk', 'search' => $search, 'category' => $categoryId]) }}" class="px-4 py-2 text-sm font-medium {{ $tab === 'produk' ? 'bg-kauman-primary text-white' : 'bg-white text-gray-700 hover:bg-olive-50' }} transition-colors">Produk</a>
                    <a href="{{ route('home', ['tab' => 'umkm', 'search' => $search, 'category' => $categoryId]) }}" class="px-4 py-2 text-sm font-medium {{ $tab === 'umkm' ? 'bg-kauman-primary text-white' : 'bg-white text-gray-700 hover:bg-olive-50' }} transition-colors">UMKM</a>
                </div>
                <select name="category" onchange="this.form.submit()" class="rounded-lg border-kauman-card-border text-sm focus:ring-kauman-primary focus:border-kauman-primary">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
                <div class="flex-1 flex gap-2">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari {{ $tab === 'umkm' ? 'UMKM' : 'produk' }}..." class="flex-1 rounded-lg border-kauman-card-border text-sm focus:ring-kauman-primary focus:border-kauman-primary placeholder-gray-400">
                    <button type="submit" class="bg-kauman-primary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary-dark transition-colors flex items-center gap-1 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Cari
                    </button>
                </div>
            </form>
        </section>

        <!-- Results -->
        <section>
            @if($items->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                @if($tab === 'produk')
                    @foreach($items as $product)
                    @include('components.product-card', ['product' => $product])
                    @endforeach
                @else
                    @foreach($items as $umkm)
                    @include('components.umkm-card', ['umkm' => $umkm])
                    @endforeach
                @endif
            </div>
            <div class="mt-8">{{ $items->links() }}</div>
            @else
            <div class="text-center py-16">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                <p class="text-gray-500 text-lg">Belum ada {{ $tab === 'umkm' ? 'UMKM' : 'produk' }} yang terdaftar.</p>
            </div>
            @endif
        </section>
    </div>
</x-app-layout>
