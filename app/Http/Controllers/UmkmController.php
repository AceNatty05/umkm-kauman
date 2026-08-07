<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\UmkmPhoto;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    use AuthorizesRequests;

    /**
     * Daftar UMKM — admin: semua, user: miliknya.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $search = $request->get('search');
        $tab = $request->get('tab', 'produk'); // produk atau umkm

        if ($user->isAdmin()) {
            $umkms = Umkm::with(['category', 'products', 'user'])
                ->search($search)
                ->latest()
                ->paginate(12)
                ->appends($request->query());
        } else {
            $umkms = $user->umkms()
                ->with(['category', 'products'])
                ->search($search)
                ->latest()
                ->paginate(12)
                ->appends($request->query());
        }

        // Jika tab produk, ambil produk
        $products = null;
        if ($tab === 'produk') {
            $productQuery = \App\Models\Product::with(['umkm', 'category']);
            if (!$user->isAdmin()) {
                $productQuery->whereIn('umkm_id', $user->umkms()->pluck('id'));
            }
            if ($search) {
                $productQuery->search($search);
            }
            $products = $productQuery->latest()->paginate(12)->appends($request->query());
        }

        $categories = Category::orderBy('name')->get();

        return view('manage.umkm.index', compact('umkms', 'products', 'tab', 'search', 'categories'));
    }

    /**
     * Form tambah UMKM baru.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('manage.umkm.create', compact('categories'));
    }

    /**
     * Simpan UMKM baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'required|image|max:2048',
            'owner_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'location' => 'nullable|url|max:500',
            'operating_hours' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
            'gallery.*' => 'nullable|image|max:2048',
            'products' => 'nullable|array',
            'products.*.name' => 'required_with:products|string|max:255',
            'products.*.photo' => 'required_with:products|image|max:2048',
            'products.*.price' => 'nullable|numeric|min:0',
            'products.*.price_unit' => 'nullable|string|max:50',
            'products.*.description' => 'required_with:products|string',
        ], [
            'name.required' => 'Nama UMKM wajib diisi.',
            'photo.required' => 'Foto UMKM wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'owner_name.required' => 'Nama pemilik wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
            'products.*.name.required_with' => 'Nama produk wajib diisi.',
            'products.*.photo.required_with' => 'Foto produk wajib diupload.',
            'products.*.description.required_with' => 'Deskripsi produk wajib diisi.',
        ]);

        // Handle kategori baru
        if (!empty($request->new_category)) {
            $category = Category::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $validated['category_id'] = $category->id;
        }

        // Upload foto utama ke storage
        $photoUrl = $request->file('photo')->store('umkm', 'public');
        if (!$photoUrl) {
            return back()->withErrors(['photo' => 'Gagal mengupload foto. Coba lagi.'])->withInput();
        }

        $umkm = $request->user()->umkms()->create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'photo' => $photoUrl,
            'owner_name' => $validated['owner_name'],
            'phone' => $validated['phone'] ?? null,
            'description' => $validated['description'],
            'location' => $validated['location'] ?? null,
            'operating_hours' => $validated['operating_hours'] ?? null,
            'category_id' => $validated['category_id'] ?? null,
        ]);

        // Upload galeri foto
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $index => $galleryPhoto) {
                $url = $galleryPhoto->store('umkm/gallery', 'public');
                if ($url) {
                    $umkm->photos()->create([
                        'photo_path' => $url,
                        'sort_order' => $index,
                    ]);
                }
            }
        }

        // Simpan produk dinamis
        if (!empty($validated['products'])) {
            foreach ($validated['products'] as $index => $productData) {
                $productPhoto = $request->file("products.{$index}.photo");
                if ($productPhoto) {
                    $productPhotoUrl = $productPhoto->store('products', 'public');
                    if ($productPhotoUrl) {
                        $umkm->products()->create([
                            'category_id' => $umkm->category_id,
                            'name' => $productData['name'],
                            'slug' => Str::slug($productData['name']),
                            'photo' => $productPhotoUrl,
                            'price' => $productData['price'] ?? null,
                            'price_unit' => $productData['price_unit'] ?? null,
                            'description' => $productData['description'],
                            'is_starred' => false,
                        ]);
                    }
                }
            }
        }

        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil ditambahkan!');
    }

    /**
     * Form edit UMKM.
     */
    public function edit(Umkm $umkm)
    {
        $this->authorize('update', $umkm);

        $umkm->load(['photos', 'products', 'category']);
        $categories = Category::orderBy('name')->get();

        return view('manage.umkm.edit', compact('umkm', 'categories'));
    }

    /**
     * Update UMKM.
     */
    public function update(Request $request, Umkm $umkm)
    {
        $this->authorize('update', $umkm);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|image|max:2048',
            'owner_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'required|string',
            'location' => 'nullable|url|max:500',
            'operating_hours' => 'nullable|string|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'new_category' => 'nullable|string|max:255',
        ]);

        // Handle kategori baru
        if (!empty($request->new_category)) {
            $category = Category::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $validated['category_id'] = $category->id;
        }

        // Upload foto baru jika ada
        if ($request->hasFile('photo')) {
            $photoUrl = $request->file('photo')->store('umkm', 'public');
            if ($photoUrl) {
                // Hapus foto lama
                if ($umkm->getRawOriginal('photo') && !str_starts_with($umkm->getRawOriginal('photo'), 'http')) {
                    Storage::disk('public')->delete($umkm->getRawOriginal('photo'));
                }
                $validated['photo'] = $photoUrl;
            }
        }

        $updateData = collect($validated)->except(['new_category'])->toArray();
        $umkm->update($updateData);

        return redirect()->route('umkm.edit', $umkm)
            ->with('success', 'UMKM berhasil diperbarui!');
    }

    /**
     * Hapus UMKM.
     */
    public function destroy(Umkm $umkm)
    {
        $this->authorize('delete', $umkm);

        if ($umkm->getRawOriginal('photo') && !str_starts_with($umkm->getRawOriginal('photo'), 'http')) {
            Storage::disk('public')->delete($umkm->getRawOriginal('photo'));
        }
        $umkm->delete(); // Soft delete

        return redirect()->route('umkm.index')
            ->with('success', 'UMKM berhasil dihapus.');
    }

    /**
     * Upload foto galeri UMKM.
     */
    public function uploadPhotos(Request $request, Umkm $umkm)
    {
        $this->authorize('update', $umkm);

        $request->validate([
            'photos.*' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('photos')) {
            $maxOrder = $umkm->photos()->max('sort_order') ?? 0;
            foreach ($request->file('photos') as $index => $photo) {
                $url = $photo->store('umkm/gallery', 'public');
                if ($url) {
                    $umkm->photos()->create([
                        'photo_path' => $url,
                        'sort_order' => $maxOrder + $index + 1,
                    ]);
                }
            }
        }

        return back()->with('success', 'Foto berhasil diupload!');
    }

    /**
     * Hapus foto galeri.
     */
    public function deletePhoto(Umkm $umkm, UmkmPhoto $photo)
    {
        $this->authorize('update', $umkm);

        if ($photo->getRawOriginal('photo_path') && !str_starts_with($photo->getRawOriginal('photo_path'), 'http')) {
            Storage::disk('public')->delete($photo->getRawOriginal('photo_path'));
        }
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
