<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\UmkmPhoto;
use App\Services\CloudinaryService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CloudinaryService $cloudinary)
    {
    }

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
        ], [
            'name.required' => 'Nama UMKM wajib diisi.',
            'photo.required' => 'Foto UMKM wajib diupload.',
            'photo.image' => 'File harus berupa gambar.',
            'photo.max' => 'Ukuran foto maksimal 2MB.',
            'owner_name.required' => 'Nama pemilik wajib diisi.',
            'description.required' => 'Deskripsi wajib diisi.',
        ]);

        // Handle kategori baru
        if (!empty($request->new_category)) {
            $category = Category::firstOrCreate(
                ['name' => $request->new_category],
                ['slug' => Str::slug($request->new_category)]
            );
            $validated['category_id'] = $category->id;
        }

        // Upload foto utama ke Cloudinary
        $photoUrl = $this->cloudinary->upload($request->file('photo'), 'umkm');
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
                $url = $this->cloudinary->upload($galleryPhoto, 'umkm/gallery');
                if ($url) {
                    $umkm->photos()->create([
                        'photo_path' => $url,
                        'sort_order' => $index,
                    ]);
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
            $photoUrl = $this->cloudinary->upload($request->file('photo'), 'umkm');
            if ($photoUrl) {
                // Hapus foto lama dari Cloudinary
                $this->cloudinary->delete($umkm->photo);
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
                $url = $this->cloudinary->upload($photo, 'umkm/gallery');
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

        $this->cloudinary->delete($photo->photo_path);
        $photo->delete();

        return back()->with('success', 'Foto berhasil dihapus.');
    }
}
