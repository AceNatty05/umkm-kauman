<x-app-layout>
    <x-slot name="title">Infografis Desa Kauman</x-slot>

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
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-kauman-primary">Infografis Desa Kauman</h1>
            <p class="mt-2 text-gray-600">Kumpulan informasi dan poster terkait pengelolaan UMKM</p>
        </div>

        @if($infografis->isEmpty())
            <div class="text-center text-gray-500 py-10 bg-white rounded-lg shadow">
                Belum ada infografis yang ditambahkan.
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($infografis as $info)
                    <div class="cursor-pointer group flex flex-col items-center" 
                         @click="openModal({{ json_encode($info->foto ?? []) }})">
                        <!-- Card background based on wireframe -->
                        <div class="w-full aspect-[3/4] bg-kauman-card border border-kauman-card-border rounded-[2rem] p-3 flex items-center justify-center overflow-hidden shadow group-hover:shadow-lg transition-shadow relative">
                            @if(!empty($info->foto) && count($info->foto) > 0)
                                <img src="{{ asset('storage/' . $info->foto[0]) }}" alt="{{ $info->nama }}" class="w-full h-full object-cover rounded-2xl">
                                @if(count($info->foto) > 1)
                                    <div class="absolute top-5 right-5 bg-black/60 text-white text-xs px-2.5 py-1 rounded-full shadow backdrop-blur-sm">
                                        +{{ count($info->foto) - 1 }}
                                    </div>
                                @endif
                            @else
                                <span class="text-kauman-primary-dark font-medium uppercase">Infografis</span>
                            @endif
                        </div>
                        <!-- Title below card -->
                        <h3 class="mt-4 text-center text-kauman-primary-dark font-semibold text-lg uppercase tracking-wide px-2">{{ $info->nama }}</h3>
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Modal -->
        <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center bg-black/80 p-2 sm:p-4 backdrop-blur-sm" x-cloak
             @keydown.escape.window="closeModal()" x-transition.opacity>
            <div class="relative w-full max-w-5xl bg-kauman-body rounded-xl overflow-hidden shadow-2xl flex flex-col" @click.away="closeModal()">
                
                <!-- Close Button -->
                <button @click="closeModal()" class="absolute top-4 right-4 z-10 p-2 bg-white/90 rounded-full text-gray-800 hover:text-red-600 shadow-md focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>

                <!-- Slider -->
                <div class="relative w-full h-[85vh] flex items-center justify-center p-4">
                    <template x-if="activeFotos.length > 0">
                        <img :src="'/storage/' + activeFotos[activeIdx]" class="max-w-full max-h-full object-contain rounded-md shadow-sm">
                    </template>
                    <template x-if="activeFotos.length === 0">
                        <div class="flex items-center justify-center w-full h-full">
                            <span class="text-gray-500">Tidak ada foto</span>
                        </div>
                    </template>
                    
                    <!-- Prev Button -->
                    <button x-show="activeFotos.length > 1 && activeIdx > 0" @click.stop="prev()" class="absolute left-2 sm:left-6 top-1/2 transform -translate-y-1/2 bg-white/90 p-2 sm:p-3 rounded-full shadow-lg hover:bg-white focus:outline-none transition-transform hover:scale-110">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                    </button>

                    <!-- Next Button -->
                    <button x-show="activeFotos.length > 1 && activeIdx < activeFotos.length - 1" @click.stop="next()" class="absolute right-2 sm:right-6 top-1/2 transform -translate-y-1/2 bg-white/90 p-2 sm:p-3 rounded-full shadow-lg hover:bg-white focus:outline-none transition-transform hover:scale-110">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                    </button>
                </div>

                <!-- Indicator -->
                <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black/60 text-white px-4 py-1.5 rounded-full text-sm font-medium tracking-wide backdrop-blur-sm" x-show="activeFotos.length > 1">
                    <span x-text="(activeIdx + 1) + ' / ' + activeFotos.length"></span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
