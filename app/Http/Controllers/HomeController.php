<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Beranda publik — produk unggulan + daftar UMKM/produk.
     */
    public function index(Request $request)
    {
        // Produk unggulan (is_starred)
        $starredProducts = Product::with('umkm')
            ->starred()
            ->latest()
            ->take(8)
            ->get();

        // Tab: produk atau umkm
        $tab = $request->get('tab', 'produk');
        $search = $request->get('search');
        $categoryId = $request->get('category');

        if ($tab === 'umkm') {
            $items = Umkm::with(['category', 'products'])
                ->search($search)
                ->byCategory($categoryId)
                ->latest()
                ->paginate(12)
                ->appends($request->query());
        } else {
            $items = Product::with(['umkm', 'category'])
                ->search($search)
                ->when($categoryId, fn($q) => $q->where('category_id', $categoryId))
                ->latest()
                ->paginate(12)
                ->appends($request->query());
        }

        $categories = Category::orderBy('name')->get();

        return view('home', compact('starredProducts', 'items', 'tab', 'search', 'categories', 'categoryId'));
    }

    /**
     * Detail UMKM publik.
     */
    public function showUmkm(string $slug)
    {
        $umkm = Umkm::with(['products', 'photos', 'category', 'user'])
            ->where('slug', $slug)
            ->firstOrFail();

        return view('umkm-detail', compact('umkm'));
    }
}
