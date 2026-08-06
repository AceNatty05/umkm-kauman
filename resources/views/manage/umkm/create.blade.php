<x-app-layout>
    <x-slot name="title">Tambah UMKM — UMKM Desa Kauman</x-slot>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Tambah UMKM Baru</h1>
        <form method="POST" action="{{ route('umkm.store') }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama <span class="text-red-500">*</span></label>
                <input type="file" name="photo" accept="image/*" required class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700 hover:file:bg-olive-200">
                @error('photo')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="owner_name" value="{{ old('owner_name') }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                @error('owner_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08xxxxxxxxxx" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">{{ old('description') }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Atau Buat Kategori Baru</label>
                    <input type="text" name="new_category" value="{{ old('new_category') }}" placeholder="Ketik nama kategori baru" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi (Link Google Maps)</label>
                <input type="url" name="location" value="{{ old('location') }}" placeholder="https://maps.google.com/..." class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours') }}" placeholder="Misal: 08:00 - 17:00" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Galeri (opsional, bisa pilih banyak)</label>
                <input type="file" name="gallery[]" accept="image/*" multiple class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700 hover:file:bg-olive-200">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan UMKM</button>
                <a href="{{ route('umkm.index') }}" class="px-6 py-3 rounded-lg font-semibold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
