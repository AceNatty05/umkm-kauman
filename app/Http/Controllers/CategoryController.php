<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * List kategori (JSON untuk AJAX).
     */
    public function index()
    {
        return response()->json(
            Category::orderBy('name')->get(['id', 'name', 'slug'])
        );
    }

    /**
     * Buat kategori baru (JSON untuk AJAX).
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json($category, 201);
    }
}
