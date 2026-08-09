<x-app-layout>
    <x-slot name="title">Infografis Desa Kauman</x-slot>

    <!-- Header Section -->
    <section class="hero-animated-gradient relative text-white py-12 sm:py-16 overflow-hidden">
        <div class="hero-blob w-64 h-64 bg-kauman-primary-light/30 -top-16 -right-16" style="animation-delay: 1s;"></div>
        <div class="hero-blob w-48 h-48 bg-olive-400/20 bottom-0 left-1/4" style="animation-delay: 4s;"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Kumpulan Infografis</h1>
            <p class="mt-3 text-green-100/80 text-lg max-w-xl mx-auto">Kumpulan informasi dan poster terkait pengelolaan UMKM</p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12" x-data="{
        modalOpen: false,
        activeFotos: [],
        activeIdx: 0,
        openModal(fotos) {
            this.activeFotos = fotos || [];
            this.activeIdx = 0;
            this.modalOpen = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.modalOpen = false;
            document.body.style.overflow = 'auto';
        },
        next() {
            if(this.activeIdx < this.activeFotos.length - 1) this.activeIdx++;
        },
        prev() {
            if(this.activeIdx > 0) this.activeIdx--;
        }
    }">
        @if($infografis->isEmpty())
            <div class="text-center text-gray-500 py-16 bg-white rounded-2xl shadow-sm border border-olive-100">
                <div class="w-16 h-16 mx-auto bg-olive-100 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-olive-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <p class="font-medium text-gray-600">Belum ada infografis yang ditambahkan.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($infografis as $i => $info)
                    <div class="cursor-pointer group flex flex-col items-center fade-up" style="animation-delay: {{ $i * 0.08 }}s"
                         @click="openModal({{ json_encode($info->foto ?? []) }})">
                        <div class="card-glow w-full aspect-[3/4] bg-white border border-olive-200/60 rounded-2xl p-3 flex items-center justify-center overflow-hidden shadow-sm relative">
                            @if(!empty($info->foto) && count($info->foto) > 0)
                                <div class="img-zoom-container w-full h-full rounded-xl overflow-hidden">
                                    <img src="{{ asset('storage/' . $info->foto[0]) }}" alt="{{ $info->nama }}" class="w-full h-full object-cover" loading="lazy">
                                </div>
                                @if(count($info->foto) > 1)
                                    <div class="absolute top-5 right-5 bg-black/50 backdrop-blur-sm text-white text-xs px-2.5 py-1 rounded-full shadow flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14"/></svg>
                                        +{{ count($info->foto) - 1 }}
                                    </div>
                                @endif
                            @else
                                <span class="text-olive-400 font-medium uppercase">Infografis</span>
                            @endif
                        </div>
                        <h3 class="mt-4 text-center text-kauman-primary-dark font-semibold text-base uppercase tracking-wide px-2 group-hover:text-kauman-primary transition-colors duration-300">{{ $info->nama }}</h3>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-2 sm:p-4 backdrop-blur-sm" x-cloak
             @keydown.escape.window="closeModal()" x-transition.opacity>
            <div class="relative w-full max-w-5xl bg-kauman-body rounded-2xl overflow-hidden shadow-2xl flex flex-col" @click.away="closeModal()">

                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 z-10 p-2.5 bg-white/90 backdrop-blur-sm rounded-full text-gray-800 hover:text-red-600 shadow-lg focus:outline-none transition-all duration-200 hover:scale-110">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Slider -->
                <div class="relative w-full h-[85vh] flex items-center justify-center p-4">
                    <template x-if="activeFotos.length > 0">
                        <img :src="'/storage/' + activeFotos[activeIdx]" class="max-w-full max-h-full object-contain rounded-lg shadow-sm">
                    </template>
                    <template x-if="activeFotos.length === 0">
                        <div class="flex items-center justify-center w-full h-full">
                            <span class="text-gray-500">Tidak ada foto</span>
                        </div>
                    </template>

                    <!-- Prev Button -->
                    <button x-show="activeFotos.length > 1 && activeIdx > 0" @click.stop="prev()" class="absolute left-2 sm:left-6 top-1/2 transform -translate-y-1/2 bg-white/90 backdrop-blur-sm p-2.5 sm:p-3 rounded-full shadow-lg hover:bg-white focus:outline-none transition-all hover:scale-110">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <!-- Next Button -->
                    <button x-show="activeFotos.length > 1 && activeIdx < activeFotos.length - 1" @click.stop="next()" class="absolute right-2 sm:right-6 top-1/2 transform -translate-y-1/2 bg-white/90 backdrop-blur-sm p-2.5 sm:p-3 rounded-full shadow-lg hover:bg-white focus:outline-none transition-all hover:scale-110">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Indicator -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/50 backdrop-blur-sm text-white px-5 py-2 rounded-full text-sm font-medium tracking-wide" x-show="activeFotos.length > 1">
                    <span x-text="(activeIdx + 1) + ' / ' + activeFotos.length"></span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
