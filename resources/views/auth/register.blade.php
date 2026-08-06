<x-guest-layout>
    <x-slot name="title">Daftar — UMKM Desa Kauman</x-slot>
    <h2 class="text-2xl font-bold text-center text-kauman-primary mb-6">Daftar Akun</h2>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx"
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
            <input id="password" type="password" name="password" required
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>
        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required
                   class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
        </div>
        <button type="submit" class="w-full bg-kauman-primary text-white py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Daftar & Kirim OTP</button>
    </form>
    <p class="text-center text-sm text-gray-500 mt-6">Sudah punya akun? <a href="{{ route('login') }}" class="text-kauman-primary font-semibold hover:underline">Masuk</a></p>
</x-guest-layout>
