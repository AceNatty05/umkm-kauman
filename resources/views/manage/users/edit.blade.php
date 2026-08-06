<x-app-layout>
    <x-slot name="title">Edit User — {{ $user->name }}</x-slot>
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit User: {{ $user->name }}</h1>
        <form method="POST" action="{{ route('users.update', $user) }}" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
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
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                <input type="password" name="password" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah password.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan Perubahan</button>
                <a href="{{ route('users.index') }}" class="px-6 py-3 rounded-lg font-semibold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
