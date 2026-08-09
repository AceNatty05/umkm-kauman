<x-app-layout>
    <x-slot name="title">UMKM Desa Kauman — Beranda</x-slot>

    <!-- ==================== HERO ==================== -->
    <section class="hero-animated-gradient relative text-white py-16 sm:py-24 overflow-hidden">
        <!-- Floating Blobs -->
        <div class="hero-blob w-72 h-72 bg-kauman-primary-light/40 -top-20 -left-20" style="animation-delay: 0s;"></div>
        <div class="hero-blob w-96 h-96 bg-olive-400/30 -bottom-32 -right-16" style="animation-delay: 3s;"></div>
        <div class="hero-blob w-48 h-48 bg-kauman-accent/20 top-1/2 left-1/3" style="animation-delay: 5s;"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm text-green-100 mb-6 border border-white/10">
                <svg class="w-4 h-4 text-kauman-primary-light" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
                Desa Kauman, Kec. Comal, Kab. Pemalang
            </div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-5 tracking-tight leading-tight">
                Belanja Langsung dari <span class="text-kauman-primary-light">Pengrajin Lokal</span>
            </h1>
            <p class="text-lg sm:text-xl text-green-100/80 max-w-2xl mx-auto leading-relaxed">
                Dari tangan terampil warga Desa Kauman, hadir produk berkualitas yang siap Anda jelajahi. Kenali usahanya, hubungi langsung, dan dukung ekonomi desa!
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-3">
                <a href="{{ route('home', ['tab' => 'produk']) }}#katalog" class="inline-flex items-center gap-2 bg-white text-kauman-primary font-semibold px-7 py-3 rounded-full shadow-lg shadow-black/10 hover:shadow-xl hover:bg-olive-50 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    Jelajahi Produk
                </a>
                <a href="{{ route('home', ['tab' => 'umkm']) }}#katalog" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white font-semibold px-7 py-3 rounded-full border border-white/20 hover:bg-white/20 transition-all duration-300 hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    Lihat Daftar UMKM
                </a>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- ==================== PRODUK UNGGULAN ==================== -->
        @if($starredProducts->count() > 0)
        <section class="mb-12 reveal-on-scroll">
            <div class="flex items-center gap-3 mb-7">
                <div class="badge-star flex items-center gap-2 bg-gradient-to-r from-amber-400 to-yellow-500 text-white px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    Produk Unggulan
                </div>
                <div class="flex-1 h-px bg-gradient-to-r from-amber-300/50 to-transparent"></div>
            </div>
            <div class="flex overflow-x-auto gap-5 pb-4 -mx-4 px-4 snap-x snap-mandatory" style="scrollbar-width:thin;">
                @foreach($starredProducts as $product)
                @include('components.product-card', ['product' => $product, 'starred' => true])
                @endforeach
            </div>
        </section>
        @endif

        <!-- ==================== KATALOG (AJAX) ==================== -->
        <div id="katalog" x-data="katalog()" x-init="init()" class="reveal-on-scroll" style="scroll-margin-top: 5rem;">
            <!-- Skeleton overlay -->
            <template x-if="loading">
                <div class="space-y-6 animate-pulse" aria-label="Memuat konten...">
                    <!-- Skeleton search bar -->
                    <div class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                        <div class="skeleton h-10 w-44"></div>
                        <div class="skeleton h-10 w-40"></div>
                        <div class="skeleton h-10 flex-1"></div>
                    </div>
                    <!-- Skeleton grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        <div class="skeleton h-72 rounded-2xl"></div>
                        <div class="skeleton h-72 rounded-2xl"></div>
                        <div class="skeleton h-72 rounded-2xl hidden sm:block"></div>
                        <div class="skeleton h-72 rounded-2xl hidden lg:block"></div>
                    </div>
                </div>
            </template>

            <!-- Actual content -->
            <div x-show="!loading" x-transition:enter="transition ease-out duration-400" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" id="katalog-content">
                <!-- ---- Search & Tabs ---- -->
                <section class="mb-8">
                    <form method="GET" action="{{ route('home') }}#katalog" class="flex flex-col sm:flex-row gap-3 items-stretch sm:items-center">
                        <!-- Tab Pills -->
                        <div class="flex rounded-full overflow-hidden bg-olive-100 p-1 shrink-0 shadow-inner">
                            <a href="{{ route('home', ['tab' => 'produk', 'search' => $search, 'category' => $categoryId]) }}#katalog"
                               class="ajax-link tab-pill px-5 py-2 text-sm font-semibold rounded-full {{ $tab === 'produk' ? 'active' : 'text-gray-600' }}">
                                Produk
                            </a>
                            <a href="{{ route('home', ['tab' => 'umkm', 'search' => $search, 'category' => $categoryId]) }}#katalog"
                               class="ajax-link tab-pill px-5 py-2 text-sm font-semibold rounded-full {{ $tab === 'umkm' ? 'active' : 'text-gray-600' }}">
                                UMKM
                            </a>
                        </div>

                        <!-- Category Dropdown -->
                        <select name="category" class="rounded-xl border-olive-200 text-sm focus:ring-kauman-primary focus:border-kauman-primary bg-white shadow-sm hover:border-olive-300 transition-colors cursor-pointer">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $categoryId == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>

                        <!-- Search Input -->
                        <div class="flex-1 flex gap-2">
                            <input type="hidden" name="tab" value="{{ $tab }}">
                            <input type="text" name="search" value="{{ $search }}"
                                   placeholder="Cari {{ $tab === 'umkm' ? 'UMKM' : 'produk' }}..."
                                   class="search-glow flex-1 rounded-xl border-olive-200 text-sm placeholder-gray-400 bg-white shadow-sm transition-all duration-300">
                            <button type="submit" class="bg-kauman-primary text-white px-6 py-2.5 rounded-xl text-sm font-semibold hover:bg-kauman-primary-dark transition-all duration-300 flex items-center gap-2 shrink-0 shadow-sm hover:shadow-md hover:-translate-y-0.5 active:translate-y-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                Cari
                            </button>
                        </div>
                    </form>
                </section>

                <!-- ---- Results ---- -->
                <section>
                    @if($items->count() > 0)
                    <div class="grid {{ $tab === 'produk' ? 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4' : 'grid-cols-1 sm:grid-cols-2 xl:grid-cols-3' }} gap-6">
                        @if($tab === 'produk')
                            @foreach($items as $i => $product)
                            <div class="fade-up" style="animation-delay: {{ $i * 0.07 }}s">
                                @include('components.product-card', ['product' => $product])
                            </div>
                            @endforeach
                        @else
                            @foreach($items as $i => $umkm)
                            <div class="fade-up" style="animation-delay: {{ $i * 0.07 }}s">
                                @include('components.umkm-card', ['umkm' => $umkm])
                            </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="mt-10">{{ $items->links() }}</div>
                    @else
                    <div class="text-center py-20">
                        <div class="w-20 h-20 mx-auto bg-olive-100 rounded-2xl flex items-center justify-center mb-5">
                            <svg class="w-10 h-10 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                        </div>
                        <p class="text-gray-500 text-lg font-medium">Belum ada {{ $tab === 'umkm' ? 'UMKM' : 'produk' }} yang terdaftar.</p>
                        <p class="text-gray-400 text-sm mt-1">Coba ubah kata kunci atau filter pencarian Anda.</p>
                    </div>
                    @endif
                </section>
            </div>
        </div>
    </div>

    <!-- ==================== AJAX Script ==================== -->
    <script>
        function katalog() {
            return {
                loading: false,
                init() {
                    this.$el.addEventListener('click', (e) => {
                        const link = e.target.closest('a');
                        if (link && link.href && (link.classList.contains('ajax-link') || link.closest('nav[role="navigation"]'))) {
                            e.preventDefault();
                            this.fetchContent(link.href);
                        }
                    });
                    this.$el.addEventListener('submit', (e) => {
                        const form = e.target.closest('form');
                        if (form) {
                            e.preventDefault();
                            const formData = new FormData(form);
                            const url = new URL(form.action);
                            const params = new URLSearchParams(formData);
                            url.search = params.toString();
                            this.fetchContent(url.toString());
                        }
                    });
                    this.$el.addEventListener('change', (e) => {
                        const select = e.target.closest('select[name="category"]');
                        if (select) {
                            e.preventDefault();
                            select.closest('form').dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                        }
                    });
                },
                async fetchContent(url) {
                    this.loading = true;
                    try {
                        const response = await fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
                        const html = await response.text();
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newContent = doc.getElementById('katalog-content');
                        if (newContent) {
                            const contentEl = this.$el.querySelector('#katalog-content');
                            if (contentEl) {
                                contentEl.innerHTML = newContent.innerHTML;
                            }
                            window.history.pushState({}, '', url);
                        } else {
                            window.location.href = url;
                        }
                    } catch (e) {
                        window.location.href = url;
                    }
                    // Small delay to let skeleton show for perceived smoothness
                    await new Promise(r => setTimeout(r, 250));
                    this.loading = false;
                }
            }
        }
    </script>
</x-app-layout>
