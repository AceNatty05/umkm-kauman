<x-app-layout>
    <x-slot name="title">Profil Saya — UMKM Desa Kauman</x-slot>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Profil Saya</h1>

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5">
            @csrf @method('PATCH')

            <!-- Photo -->
            <div class="flex items-center gap-4">
                <img src="{{ $user->photo_url }}" alt="{{ $user->name }}" class="w-20 h-20 rounded-full object-cover border-2 border-kauman-card-border">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                    <input type="file" name="photo" accept="image/*" class="text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700">
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>

            <div class="flex items-center gap-2 text-sm text-gray-500">
                <span class="px-2.5 py-1 rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-700' : 'bg-olive-100 text-olive-700' }} font-medium text-xs">{{ ucfirst($user->role) }}</span>
                <span>•</span>
                <span>Terdaftar {{ $user->created_at->translatedFormat('d M Y') }}</span>
            </div>

            <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan Profil</button>
        </form>
    </div>
</x-app-layout>
