<x-app-layout>
    <x-slot name="title">Tambah User — UMKM Desa Kauman</x-slot>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah User Baru</h1>
        <form method="POST" action="{{ route('users.store') }}" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp <span class="text-red-500">*</span></label>
                <input type="text" name="phone" value="{{ old('phone') }}" required placeholder="08xxxxxxxxxx" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('phone')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                    <option value="user" {{ old('role') === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <label class="flex items-center space-x-2 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="rounded border-gray-300 text-kauman-primary focus:ring-kauman-primary w-5 h-5">
                    <span class="text-sm font-medium text-gray-700">Akun Langsung Aktif</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('password')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan</button>
                <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-lg font-semibold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
