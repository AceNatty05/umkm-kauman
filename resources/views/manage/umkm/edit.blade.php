<x-app-layout>
    <x-slot name="title">Edit {{ $umkm->name }} — UMKM Desa Kauman</x-slot>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit UMKM: {{ $umkm->name }}</h1>

        <!-- Edit Form -->
        <form method="POST" action="{{ route('umkm.update', $umkm) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5 mb-8">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama UMKM <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $umkm->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Utama</label>
                <img src="{{ $umkm->photo }}" alt="{{ $umkm->name }}" class="w-32 h-24 object-cover rounded-lg mb-2">
                <input type="file" name="photo" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah foto.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Pemilik <span class="text-red-500">*</span></label>
                <input type="text" name="owner_name" value="{{ old('owner_name', $umkm->owner_name) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone', $umkm->phone) }}" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                <textarea name="description" rows="4" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">{{ old('description', $umkm->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $umkm->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Atau Buat Kategori Baru</label>
                    <input type="text" name="new_category" placeholder="Ketik nama kategori baru" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi (Link Google Maps)</label>
                <input type="url" name="location" value="{{ old('location', $umkm->location) }}" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                <input type="text" name="operating_hours" value="{{ old('operating_hours', $umkm->operating_hours) }}" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan Perubahan</button>
        </form>

        <!-- Gallery -->
        <div class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Galeri Foto</h2>
            @if($umkm->photos->count() > 0)
            <div class="grid grid-cols-3 sm:grid-cols-4 gap-3 mb-4">
                @foreach($umkm->photos as $photo)
                <div class="relative group">
                    <img src="{{ $photo->photo_path }}" class="w-full aspect-square object-cover rounded-lg">
                    <form method="POST" action="{{ route('umkm.photos.destroy', [$umkm, $photo]) }}" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Hapus foto?')" class="bg-red-500 text-white p-1 rounded-full hover:bg-red-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                    </form>
                </div>
                @endforeach
            </div>
            @endif
            <form method="POST" action="{{ route('umkm.photos.store', $umkm) }}" enctype="multipart/form-data" class="flex gap-3">
                @csrf
                <input type="file" name="photos[]" accept="image/*" multiple required class="flex-1 text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700">
                <button type="submit" class="bg-kauman-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary-dark transition-colors">Upload</button>
            </form>
        </div>

        <!-- Products -->
        <div class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Produk ({{ $umkm->products->count() }})</h2>
                <a href="{{ route('products.create', $umkm) }}" class="bg-kauman-primary text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary-dark transition-colors flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tambah Produk
                </a>
            </div>
            @if($umkm->products->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($umkm->products as $product)
                <div class="bg-kauman-card rounded-xl border border-kauman-card-border p-3">
                    <img src="{{ $product->photo }}" class="w-full h-32 object-cover rounded-lg mb-2">
                    <h3 class="font-semibold text-sm truncate">{{ $product->name }}</h3>
                    @if($product->formatted_price)<p class="text-kauman-primary text-xs font-bold">{{ $product->formatted_price }}</p>@endif
                    <div class="flex gap-1 mt-2">
                        <a href="{{ route('products.edit', [$umkm, $product]) }}" class="text-xs bg-green-500 text-white rounded px-2 py-1 hover:bg-green-600">Edit</a>
                        <form method="POST" action="{{ route('products.toggle-star', [$umkm, $product]) }}">@csrf @method('PATCH')
                            <button class="text-xs {{ $product->is_starred ? 'bg-yellow-500' : 'bg-yellow-400' }} text-white rounded px-2 py-1 hover:bg-yellow-600">{{ $product->is_starred ? '★' : '☆' }}</button>
                        </form>
                        <form method="POST" action="{{ route('products.destroy', [$umkm, $product]) }}" onsubmit="return confirm('Hapus?')">@csrf @method('DELETE')
                            <button class="text-xs bg-red-500 text-white rounded px-2 py-1 hover:bg-red-600">Hapus</button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <p class="text-gray-500 text-sm">Belum ada produk.</p>
            @endif
        </div>
    </div>
</x-app-layout>
