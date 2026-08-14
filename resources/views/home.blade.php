<x-app-layout>
    <x-slot name="title">UMKM Desa Kauman — Beranda</x-slot>

    <!-- ==================== HERO CAROUSEL ==================== -->
    <section x-data="heroCarousel()" class="relative w-full overflow-hidden transition-colors duration-700 ease-in-out font-sans" :style="{ backgroundColor: currentSlideData.bgColor, color: currentSlideData.textColor }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 lg:py-14 relative z-10 flex flex-col justify-center min-h-[calc(100vh-80px)] lg:min-h-0">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center flex-1">
                <!-- Left Text Content -->
                <div class="lg:col-span-5 flex flex-col justify-center order-2 lg:order-1 relative min-h-[280px] sm:min-h-[260px] lg:min-h-[320px]">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index" 
                             x-transition:enter="transition ease-out duration-700 delay-150"
                             x-transition:enter-start="opacity-0 translate-y-8"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-300 absolute top-0 left-0 w-full"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0 -translate-y-4"
                             class="w-full pt-2 lg:pt-0">
                             
                            <h3 class="text-xs sm:text-sm font-bold tracking-widest uppercase mb-3 sm:mb-4 opacity-90" x-text="slide.subtitle"></h3>
                            <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold mb-4 sm:mb-6 leading-[1.1] tracking-tight" x-text="slide.title"></h1>
                            <p class="text-base sm:text-lg mb-6 sm:mb-8 max-w-lg leading-relaxed opacity-85" x-text="slide.description"></p>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-wrap gap-3 sm:gap-4 relative z-20">
                                <a href="{{ route('home', ['tab' => 'umkm']) }}#katalog" 
                                   class="inline-flex items-center justify-center gap-2 font-semibold px-6 sm:px-8 py-3 sm:py-3.5 rounded-full shadow-lg shadow-black/5 transition-all duration-300 hover:scale-105 active:scale-95"
                                   :style="{ backgroundColor: slide.btnBg, color: slide.btnText }">
                                    Jelajahi UMKM <span aria-hidden="true">&rarr;</span>
                                </a>
                                <a href="{{ route('home', ['tab' => 'produk']) }}#katalog" 
                                   class="inline-flex items-center justify-center gap-2 border font-semibold px-6 sm:px-8 py-3 sm:py-3.5 rounded-full transition-all duration-300 hover:bg-black/5"
                                   :style="{ borderColor: slide.textColor, color: slide.textColor }">
                                    Jelajahi Produk
                                </a>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Right Image Content -->
                <div class="lg:col-span-7 relative h-[300px] sm:h-[450px] lg:h-[550px] xl:h-[600px] order-1 lg:order-2 w-full mt-4 lg:mt-0">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div x-show="activeSlide === index"
                             x-transition:enter="transition ease-out duration-1000"
                             x-transition:enter-start="opacity-0 scale-95 translate-x-8"
                             x-transition:enter-end="opacity-100 scale-100 translate-x-0"
                             x-transition:leave="transition ease-in duration-500 absolute inset-0 z-0"
                             x-transition:leave-start="opacity-100 scale-100"
                             x-transition:leave-end="opacity-0 scale-105"
                             class="w-full h-full absolute inset-0 z-10">
                             
                            <div class="w-full h-full relative overflow-hidden group"
                                 :class="index === 0 ? 'bg-transparent shadow-none' : 'rounded-[2rem] sm:rounded-[2.5rem] lg:rounded-[3rem] shadow-2xl shadow-black/10'">
                                <img :src="slide.image" :alt="slide.title" 
                                     class="w-full h-full object-center transform transition-transform duration-[10000ms] ease-linear group-hover:scale-105"
                                     :class="index === 0 ? 'object-contain' : 'object-cover'" />
                                
                                <!-- Glassmorphism Caption -->
                                <div x-show="index !== 0"
                                     class="absolute bottom-4 left-4 right-4 sm:bottom-6 sm:left-6 sm:right-6 bg-white/20 backdrop-blur-md border border-white/30 p-4 sm:p-5 rounded-2xl sm:rounded-[1.5rem] text-white transform transition-all duration-500 hover:bg-white/30 shadow-lg">
                                    <h4 class="font-bold text-base sm:text-lg lg:text-xl text-shadow-sm" x-text="slide.captionTitle"></h4>
                                    <p class="text-xs sm:text-sm lg:text-base opacity-90 mt-0.5 sm:mt-1 font-medium text-shadow-sm" x-text="slide.captionSubtitle"></p>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <!-- Floating Badge -->
                    <div x-show="activeSlide !== 0" class="absolute -bottom-4 lg:-bottom-6 left-1/2 -translate-x-1/2 z-30">
                        <div class="bg-white px-5 sm:px-6 py-2.5 sm:py-3 rounded-full shadow-xl font-semibold text-xs sm:text-sm text-gray-800 whitespace-nowrap flex items-center gap-2 border border-gray-100 transform hover:-translate-y-1 transition-transform cursor-default">
                            <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                            Dukung Produk Lokal
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Pagination & Controls -->
            <div class="flex items-center justify-between mt-12 sm:mt-16 lg:mt-12 pt-6 sm:pt-8 w-full z-20">
                <!-- Counter -->
                <div class="flex items-end gap-1.5 sm:gap-2 font-medium w-1/3">
                    <span class="text-2xl sm:text-3xl lg:text-4xl font-extrabold tracking-tighter" x-text="String(activeSlide + 1).padStart(2, '0')"></span>
                    <span class="text-xs sm:text-sm lg:text-base opacity-50 pb-0.5 sm:pb-1 font-bold" x-text="'/ ' + String(slides.length).padStart(2, '0')"></span>
                </div>
                
                <!-- Dots -->
                <div class="flex gap-1.5 sm:gap-2 lg:gap-3 justify-center w-1/3">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="goTo(index)" 
                                class="h-1 sm:h-1.5 rounded-full transition-all duration-500 ease-out hover:opacity-80" 
                                :class="activeSlide === index ? 'w-6 sm:w-8 lg:w-12' : 'w-1.5 sm:w-2 lg:w-3 opacity-30'"
                                :style="{ backgroundColor: currentSlideData.textColor }">
                        </button>
                    </template>
                </div>
                
                <!-- Arrows -->
                <div class="flex gap-2 sm:gap-3 lg:gap-4 justify-end w-1/3">
                    <button @click="prev" 
                            class="w-9 h-9 sm:w-11 sm:h-11 lg:w-14 lg:h-14 rounded-full border-2 flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 hover:bg-black/5" 
                            :style="{ borderColor: currentSlideData.textColor, color: currentSlideData.textColor }">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                    </button>
                    <button @click="next" 
                            class="w-9 h-9 sm:w-11 sm:h-11 lg:w-14 lg:h-14 rounded-full border-2 flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 hover:bg-black/5" 
                            :style="{ borderColor: currentSlideData.textColor, color: currentSlideData.textColor }">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                    </button>
                </div>
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
        function heroCarousel() {
            return {
                activeSlide: 0,
                autoplayInterval: null,
                slides: [
                    {
                        subtitle: 'POTENSI DESA',
                        title: 'Kenali UMKM di Desa Kauman',
                        description: '[Deskripsi perkenalan potensi UMKM Desa Kauman (las, tahu, konveksi) dapat Anda isi di sini...]',
                        image: '{{ asset("images/persebaran_umkm_unggulan_kauman.png") }}',
                        captionTitle: 'Jelajahi UMKM Lokal',
                        captionSubtitle: 'Desa Kauman',
                        bgColor: '#556B2F',
                        textColor: '#ffffff',
                        btnBg: '#ffffff',
                        btnText: '#556B2F'
                    },
                    {
                        subtitle: 'PRODUK LOKAL',
                        title: 'Industri Las & Rekayasa Logam',
                        description: '[Deskripsi mengenai UMKM Bengkel Las dapat Anda isi di sini...]',
                        image: '{{ asset("images/umkm_las.png") }}',
                        captionTitle: 'Bengkel Las Kauman',
                        captionSubtitle: 'Desa Kauman',
                        bgColor: '#334155',
                        textColor: '#f8fafc',
                        btnBg: '#f8fafc',
                        btnText: '#0f172a'
                    },
                    {
                        subtitle: 'JELAJAHI UMKM',
                        title: 'Pusat Pembuatan Tahu Segar',
                        description: '[Deskripsi mengenai UMKM Produksi Tahu dapat Anda isi di sini...]',
                        image: '{{ asset("images/umkm_tahu.JPG") }}',
                        captionTitle: 'Produksi Tahu Lokal',
                        captionSubtitle: 'Desa Kauman',
                        bgColor: '#fef3c7',
                        textColor: '#78350f',
                        btnBg: '#78350f',
                        btnText: '#ffffff'
                    },
                    {
                        subtitle: 'DUKUNG UMKM LOKAL',
                        title: 'Industri Konveksi Pakaian',
                        description: '[Deskripsi mengenai UMKM Konveksi dapat Anda isi di sini...]',
                        image: '{{ asset("images/umkm_konveksi.JPG") }}',
                        captionTitle: 'Konveksi Kauman',
                        captionSubtitle: 'Desa Kauman',
                        bgColor: '#bfdbfe',
                        textColor: '#1e3a8a',
                        btnBg: '#1e3a8a',
                        btnText: '#ffffff'
                    }
                ],
                get currentSlideData() {
                    return this.slides[this.activeSlide];
                },
                next() {
                    this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                    this.resetAutoplay();
                },
                prev() {
                    this.activeSlide = (this.activeSlide === 0) ? this.slides.length - 1 : this.activeSlide - 1;
                    this.resetAutoplay();
                },
                goTo(index) {
                    this.activeSlide = index;
                    this.resetAutoplay();
                },
                startAutoplay() {
                    this.autoplayInterval = setInterval(() => {
                        this.activeSlide = (this.activeSlide === this.slides.length - 1) ? 0 : this.activeSlide + 1;
                    }, 5000);
                },
                resetAutoplay() {
                    clearInterval(this.autoplayInterval);
                    this.startAutoplay();
                },
                init() {
                    this.startAutoplay();
                }
            }
        }

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
