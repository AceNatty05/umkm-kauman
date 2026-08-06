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
    <p class="text-center text-sm text-gray-500 mt-6">Belum punya akun? <a href="{{ route('register') }}" class="text-kauman-primary font-semibold hover:underline">Daftar</a></p>
</x-guest-layout>
