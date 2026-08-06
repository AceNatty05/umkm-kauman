<x-app-layout>
    <x-slot name="title">Dashboard — UMKM Desa Kauman</x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Dashboard</h1>
        <p class="text-gray-500 mb-8">Selamat datang, {{ auth()->user()->name }}!</p>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-{{ $totalUsers !== null ? '3' : '2' }} gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-kauman-card-border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total UMKM</p>
                        <p class="text-3xl font-bold text-kauman-primary mt-1">{{ $totalUmkm }}</p>
                    </div>
                    <div class="w-12 h-12 bg-olive-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-kauman-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-kauman-card-border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Produk</p>
                        <p class="text-3xl font-bold text-kauman-secondary mt-1">{{ $totalProducts }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-kauman-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                </div>
            </div>
            @if($totalUsers !== null)
            <div class="bg-white rounded-xl shadow-sm border border-kauman-card-border p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total User</p>
                        <p class="text-3xl font-bold text-amber-600 mt-1">{{ $totalUsers }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Quick Actions -->
        <div class="flex gap-3 mb-8">
            <a href="{{ route('umkm.create') }}" class="bg-kauman-primary text-white px-5 py-2.5 rounded-lg font-medium hover:bg-kauman-primary-dark transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah UMKM
            </a>
            <a href="{{ route('umkm.index') }}" class="bg-white text-kauman-primary border border-kauman-primary px-5 py-2.5 rounded-lg font-medium hover:bg-olive-50 transition-colors">
                Kelola UMKM
            </a>
        </div>

        <!-- Recent UMKM -->
        @if($recentUmkm->count() > 0)
        <h2 class="text-xl font-bold text-gray-800 mb-4">UMKM Terbaru</h2>
        <div class="bg-white rounded-xl shadow-sm border border-kauman-card-border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-olive-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold hidden sm:table-cell">Pemilik</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold hidden md:table-cell">Kategori</th>
                        <th class="px-4 py-3 text-left text-gray-700 font-semibold">Produk</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recentUmkm as $umkm)
                    <tr class="hover:bg-olive-50/50">
                        <td class="px-4 py-3 font-medium">{{ $umkm->name }}</td>
                        <td class="px-4 py-3 text-gray-500 hidden sm:table-cell">{{ $umkm->owner_name }}</td>
                        <td class="px-4 py-3 hidden md:table-cell">
                            @if($umkm->category)<span class="text-xs bg-olive-100 text-olive-700 rounded-full px-2 py-0.5">{{ $umkm->category->name }}</span>@else <span class="text-gray-400">-</span> @endif
                        </td>
                        <td class="px-4 py-3">{{ $umkm->products_count ?? $umkm->products->count() }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</x-app-layout>
