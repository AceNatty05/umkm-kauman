<x-app-layout>
    <x-slot name="title">Dashboard — UMKM Desa Kauman</x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 tracking-tight">Dashboard</h1>
            <p class="text-gray-400 mt-1">Selamat datang, <span class="text-kauman-primary font-medium">{{ auth()->user()->name }}</span>!</p>
        </div>

        @if(!auth()->user()->is_active)
        <div class="bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl p-5 mb-8 flex items-start space-x-3 shadow-sm">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-amber-800 font-bold">Menunggu Persetujuan</h3>
                <p class="text-amber-700 text-sm mt-1 leading-relaxed">Akun Anda sedang dalam proses peninjauan oleh Admin. Anda belum dapat mengelola atau mendaftarkan UMKM sebelum akun disetujui. Silakan hubungi Admin jika butuh bantuan.</p>
            </div>
        </div>
        @endif

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $totalUsers !== null ? '3' : '2' }} gap-6 mb-8">
            <div class="bg-white rounded-2xl shadow-sm border border-olive-100 p-6 card-glow reveal-on-scroll">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400 uppercase tracking-wider font-medium">Total UMKM</p>
                        <p class="text-3xl font-bold text-kauman-primary mt-1">{{ $totalUmkm }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-olive-100 to-olive-200 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-kauman-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-olive-100 p-6 card-glow reveal-on-scroll" style="animation-delay: 0.1s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400 uppercase tracking-wider font-medium">Total Produk</p>
                        <p class="text-3xl font-bold text-kauman-secondary mt-1">{{ $totalProducts }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-kauman-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
            </div>
            @if($totalUsers !== null)
            <div class="bg-white rounded-2xl shadow-sm border border-olive-100 p-6 card-glow reveal-on-scroll" style="animation-delay: 0.2s">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-400 uppercase tracking-wider font-medium">Total User</p>
                        <p class="text-3xl font-bold text-amber-600 mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-14 h-14 bg-gradient-to-br from-amber-50 to-amber-100 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-3 mb-8 reveal-on-scroll">
            <a href="{{ route('umkm.create') }}" class="btn-pill bg-kauman-primary text-white hover:bg-kauman-primary-dark shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah UMKM
            </a>
            <a href="{{ route('umkm.index') }}" class="btn-pill bg-white text-kauman-primary border border-olive-200 hover:bg-olive-50">
                Kelola UMKM
            </a>
        </div>

        <!-- Recent UMKM -->
        @if($recentUmkm->count() > 0)
        <div class="reveal-on-scroll">
            <div class="flex items-center gap-3 mb-5">
                <h2 class="text-xl font-bold text-gray-800">UMKM Terbaru</h2>
                <div class="flex-1 h-px bg-gradient-to-r from-olive-200 to-transparent"></div>
            </div>
            <div class="bg-white rounded-2xl shadow-sm border border-olive-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gradient-to-r from-olive-50 to-olive-50/50">
                        <tr>
                            <th class="px-5 py-3.5 text-left text-gray-600 font-semibold text-xs uppercase tracking-wider">Nama</th>
                            <th class="px-5 py-3.5 text-left text-gray-600 font-semibold text-xs uppercase tracking-wider hidden sm:table-cell">Pemilik</th>
                            <th class="px-5 py-3.5 text-left text-gray-600 font-semibold text-xs uppercase tracking-wider hidden md:table-cell">Kategori</th>
                            <th class="px-5 py-3.5 text-left text-gray-600 font-semibold text-xs uppercase tracking-wider">Produk</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-olive-50">
                        @foreach($recentUmkm as $umkm)
                        <tr class="hover:bg-olive-50/50 transition-colors duration-150">
                            <td class="px-5 py-3.5 font-medium text-gray-800">{{ $umkm->name }}</td>
                            <td class="px-5 py-3.5 text-gray-500 hidden sm:table-cell">{{ $umkm->owner_name }}</td>
                            <td class="px-5 py-3.5 hidden md:table-cell">
                                @if($umkm->category)<span class="text-xs bg-olive-100 text-olive-700 rounded-full px-2.5 py-0.5 font-medium">{{ $umkm->category->name }}</span>@else <span class="text-gray-400">-</span> @endif
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="bg-kauman-secondary/10 text-kauman-secondary text-xs font-semibold px-2 py-0.5 rounded-full">{{ $umkm->products_count ?? $umkm->products->count() }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>
