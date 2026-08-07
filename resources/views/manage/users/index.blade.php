<x-app-layout>
    <x-slot name="title">Manajemen User — UMKM Desa Kauman</x-slot>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Manajemen User</h1>
            <a href="{{ route('users.create') }}" class="bg-kauman-primary text-white px-5 py-2.5 rounded-lg font-medium hover:bg-kauman-primary-dark transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah User
            </a>
        </div>
        <form method="GET" class="flex gap-2 mb-6">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari user..." class="flex-1 rounded-lg border-kauman-card-border text-sm focus:ring-kauman-primary focus:border-kauman-primary">
            <button type="submit" class="bg-kauman-primary text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary-dark transition-colors">Cari</button>
        </form>
        <div class="bg-white rounded-xl shadow-sm border border-kauman-card-border overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-olive-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold">Nama</th>
                        <th class="px-4 py-3 text-left font-semibold hidden sm:table-cell">WhatsApp</th>
                        <th class="px-4 py-3 text-left font-semibold hidden md:table-cell">Email</th>
                        <th class="px-4 py-3 text-left font-semibold">Role</th>
                        <th class="px-4 py-3 text-left font-semibold">Status</th>
                        <th class="px-4 py-3 text-left font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-olive-50/50">
                        <td class="px-4 py-3 font-medium flex items-center gap-2">
                            <img src="{{ $user->photo_url }}" class="w-8 h-8 rounded-full object-cover">
                            {{ $user->name }}
                        </td>
                        <td class="px-4 py-3 text-gray-500 hidden sm:table-cell">{{ $user->phone }}</td>
                        <td class="px-4 py-3 text-gray-500 hidden md:table-cell">{{ $user->email ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="text-xs font-medium px-2.5 py-1 rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-olive-100 text-olive-700' }}">{{ ucfirst($user->role) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @if($user->is_active)
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-green-100 text-green-700">Aktif</span>
                            @else
                                <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-amber-100 text-amber-700">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex gap-1.5 flex-wrap">
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.toggle-active', $user) }}">@csrf @method('PATCH')
                                    @if($user->is_active)
                                        <button class="text-xs bg-amber-500 text-white rounded px-2.5 py-1.5 hover:bg-amber-600 w-full mb-1">Nonaktifkan</button>
                                    @else
                                        <button class="text-xs bg-green-500 text-white rounded px-2.5 py-1.5 hover:bg-green-600 w-full mb-1">Aktivasi</button>
                                    @endif
                                </form>
                                @endif
                                <a href="{{ route('users.edit', $user) }}" class="text-xs bg-blue-500 text-white rounded px-2.5 py-1.5 hover:bg-blue-600">Edit</a>
                                @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('users.destroy', $user) }}" onsubmit="return confirm('Hapus user ini?')">@csrf @method('DELETE')
                                    <button class="text-xs bg-red-500 text-white rounded px-2.5 py-1.5 hover:bg-red-600">Hapus</button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6">{{ $users->links() }}</div>
    </div>
</x-app-layout>
