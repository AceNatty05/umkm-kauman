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
            <hr class="border-gray-200 my-6">

            <div x-data="{ products: [] }">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Daftar Produk (Opsional)</h2>
                        <p class="text-sm text-gray-500">Tambahkan produk-produk andalan UMKM ini.</p>
                    </div>
                    <button type="button" @click="products.push({ id: Date.now() })" class="bg-kauman-primary/10 text-kauman-primary px-4 py-2 rounded-lg text-sm font-medium hover:bg-kauman-primary/20 transition-colors flex items-center gap-1 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Produk
                    </button>
                </div>
                
                <div class="space-y-6">
                    <template x-for="(product, index) in products" :key="product.id">
                        <div class="p-5 border border-gray-200 rounded-xl bg-gray-50 relative">
                            <button type="button" @click="products.splice(index, 1)" class="absolute top-4 right-4 text-gray-400 hover:text-red-500 transition-colors" title="Hapus Produk">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                            
                            <h3 class="font-semibold text-gray-700 mb-4" x-text="`Produk #${index + 1}`"></h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                                    <input type="text" :name="`products[${index}][name]`" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk <span class="text-red-500">*</span></label>
                                    <input type="file" :name="`products[${index}][photo]`" accept="image/*" required class="w-full text-sm file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-white file:border-gray-300 file:border file:text-gray-700 hover:file:bg-gray-50">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                    <input type="number" :name="`products[${index}][price]`" placeholder="Contoh: 15000" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan (opsional)</label>
                                    <input type="text" :name="`products[${index}][price_unit]`" placeholder="Contoh: porsi, pcs, kg" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary text-sm">
                                </div>
                                <div class="sm:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Produk <span class="text-red-500">*</span></label>
                                    <textarea :name="`products[${index}][description]`" rows="2" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </template>
                    
                    <p x-show="products.length === 0" class="text-sm text-gray-500 italic text-center py-6 bg-gray-50 rounded-xl border border-dashed border-gray-300">Belum ada produk yang ditambahkan. Klik "Tambah Produk" untuk mendaftarkan produk UMKM.</p>
                </div>
            </div>

            <div class="flex gap-3 pt-4 border-t border-gray-200 mt-6">
                <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan UMKM & Produk</button>
                <a href="{{ route('umkm.index') }}" class="px-6 py-3 rounded-lg font-semibold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
