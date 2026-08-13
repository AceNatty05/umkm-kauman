<x-guest-layout>
    <x-slot name="title">Login — UMKM Desa Kauman</x-slot>
    <h2 class="text-2xl font-bold text-center text-kauman-primary mb-6">Masuk</h2>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required autofocus placeholder="08xxxxxxxxxx"
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="flex items-center mb-6">
            <input id="remember" type="checkbox" name="remember" class="rounded border-gray-300 text-kauman-primary focus:ring-kauman-primary">
            <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
        </div>
        <button type="submit" class="w-full bg-kauman-primary text-white py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Masuk</button>
    </form>
    
    <div x-data="{ showAdmins: false }" class="mt-4 text-center">
        <button @click="showAdmins = !showAdmins" type="button" class="text-sm text-kauman-primary font-medium hover:underline focus:outline-none transition-colors">
            Akun belum terverifikasi / Lupa password?
        </button>
        
        <div x-show="showAdmins" 
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             style="display: none;"
             class="mt-3 text-sm text-gray-700 bg-gray-50 p-4 rounded-xl border border-gray-200 text-left shadow-inner">
            <p class="font-semibold text-gray-800 mb-3 border-b pb-2">Daftar Kontak Admin:</p>
            <ul class="space-y-3">
                @forelse($admins ?? [] as $admin)
                    <li>
                        @php
                            $waNumber = preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $admin->phone));
                            $waText = urlencode("Halo Admin {$admin->name}, saya mengalami kendala (akun belum diverifikasi / lupa password) pada akun UMKM saya. Mohon bantuannya.");
                        @endphp
                        <a href="https://wa.me/{{ $waNumber }}?text={{ $waText }}" 
                           target="_blank" 
                           class="flex items-center text-gray-700 hover:text-kauman-primary transition-colors group">
                           <div class="bg-green-100 p-1.5 rounded-full mr-3 group-hover:bg-green-200 transition-colors">
                               <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/></svg>
                           </div>
                           <span class="font-medium">{{ $admin->name }}</span>
                        </a>
                    </li>
                @empty
                    <li class="text-gray-500 italic text-center py-2">Belum ada kontak admin.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <p class="text-center text-sm text-gray-500 mt-6">Belum punya akun? <a href="{{ route('register') }}" class="text-kauman-primary font-semibold hover:underline">Daftar</a></p>
</x-guest-layout>
