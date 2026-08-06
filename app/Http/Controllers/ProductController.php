<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Services\CloudinaryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CloudinaryService $cloudinary)
    {
    }

    /**
     * Form tambah produk.
     */
    public function create(Umkm $umkm)
    {
        $this->authorize('update', $umkm);
        $categories = Category::orderBy('name')->get();

        return view('manage.products.create', compact('umkm', 'categories'));
    }

    /**
     * Simpan produk baru.
     */
    public function store(Request $request, Umkm $umkm)
    {
        $this->authorize('update', $umkm);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'photo.required' => 'Foto produk wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
        ]);

        // Handle kategori baru
        if (!empty($request->new_category)) {
            $category = Category::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $validated['category_id'] = $category->id;
        }

        // Upload foto
        $photoUrl = $this->cloudinary->upload($request->file('photo'), 'products');
        if (!$photoUrl) {
            return back()->withErrors(['photo' => 'Gagal mengupload foto.'])->withInput();
        }

        $umkm->products()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'photo' => $photoUrl,
            'price' => $validated['price'] ?? null,
            'price_unit' => $validated['price_unit'] ?? null,
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        return redirect()->route('umkm.edit', $umkm)
            ->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Form edit produk.
     */
    public function edit(Umkm $umkm, Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::orderBy('name')->get();

        return view('manage.products.edit', compact('umkm', 'product', 'categories'));
    }

    /**
     * Update produk.
     */
    public function update(Request $request, Umkm $umkm, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'price' => 'nullable|numeric|min:0',
            'price_unit' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ]);

        if (!empty($request->new_category)) {
            $category = Category::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $validated['category_id'] = $category->id;
        }

        if ($request->hasFile('photo')) {
            $photoUrl = $this->cloudinary->upload($request->file('photo'), 'products');
            if ($photoUrl) {
                $this->cloudinary->delete($product->photo);
                $validated['photo'] = $photoUrl;
            }
        }

        $product->update(collect($validated)->except(['new_category'])->toArray());

        return redirect()->route('umkm.edit', $umkm)
            ->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Hapus produk.
     */
    public function destroy(Umkm $umkm, Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('umkm.edit', $umkm)
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle produk unggulan (iklankan).
     */
    public function toggleStar(Umkm $umkm, Product $product)
    {
        $this->authorize('update', $product);

        $product->update(['is_starred' => !$product->is_starred]);

        $message = $product->is_starred
            ? 'Produk ditandai sebagai unggulan!'
            : 'Produk dihapus dari unggulan.';

        return back()->with('success', $message);
    }
}
