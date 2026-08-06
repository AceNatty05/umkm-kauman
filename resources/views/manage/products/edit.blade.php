<x-app-layout>
    <x-slot name="title">Edit Produk — {{ $product->name }}</x-slot>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Edit Produk</h1>
        <p class="text-gray-500 mb-6">UMKM: <strong>{{ $umkm->name }}</strong></p>
        <form method="POST" action="{{ route('products.update', [$umkm, $product]) }}" enctype="multipart/form-data" class="bg-white rounded-2xl shadow-sm border border-kauman-card-border p-6 sm:p-8 space-y-5">
            @csrf @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Foto Produk</label>
                <img src="{{ $product->photo }}" alt="{{ $product->name }}" class="w-32 h-24 object-cover rounded-lg mb-2">
                <input type="file" name="photo" accept="image/*" class="w-full text-sm file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-olive-100 file:text-olive-700">
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ingin mengubah.</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Harga</label>
                    <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Per</label>
                    <input type="text" name="price_unit" value="{{ old('price_unit', $product->price_unit) }}" placeholder="pcs, kg, porsi" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                <textarea name="description" rows="3" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">{{ old('description', $product->description) }}</textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select name="category_id" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)<option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Atau Buat Baru</label>
                    <input type="text" name="new_category" placeholder="Kategori baru" class="w-full rounded-lg border-gray-300 focus:border-kauman-primary focus:ring-kauman-primary">
                </div>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="bg-kauman-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-kauman-primary-dark transition-colors">Simpan Perubahan</button>
                <a href="{{ route('umkm.edit', $umkm) }}" class="px-6 py-3 rounded-lg font-semibold text-gray-600 hover:bg-gray-100 transition-colors">Batal</a>
            </div>
        </form>
    </div>
</x-app-layout>
