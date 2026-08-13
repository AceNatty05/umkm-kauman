<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TutorialManagementController extends Controller
{
    public function index()
    {
        $tutorials = Tutorial::latest()->paginate(10);
        return view('manage.tutorials.index', compact('tutorials'));
    }

    public function create()
    {
        return view('manage.tutorials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'target_role' => 'required|in:all,admin,user',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['is_published'] = $request->has('is_published');

        Tutorial::create($validated);

        return redirect()->route('manage.tutorials.index')->with('success', 'Tutorial berhasil ditambahkan.');
    }

    public function edit(Tutorial $tutorial)
    {
        return view('manage.tutorials.edit', compact('tutorial'));
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'video_url' => 'nullable|url',
            'target_role' => 'required|in:all,admin,user',
            'is_published' => 'boolean',
        ]);

        // Opsional: update slug jika title berubah, tapi biasanya slug dibiarkan tetap agar link tidak mati
        $validated['is_published'] = $request->has('is_published');

        $tutorial->update($validated);

        return redirect()->route('manage.tutorials.index')->with('success', 'Tutorial berhasil diperbarui.');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return redirect()->route('manage.tutorials.index')->with('success', 'Tutorial berhasil dihapus.');
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048', // max 2MB
        ]);

        $path = $request->file('file')->store('tutorials', 'public');
        $url = asset('storage/' . $path);

        return response()->json(['url' => $url]);
    }
}
