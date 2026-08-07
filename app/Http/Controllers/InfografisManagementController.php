<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Infografis;
use Illuminate\Support\Facades\Storage;

class InfografisManagementController extends Controller
{
    public function index()
    {
        $infografis = Infografis::latest()->paginate(10);
        return view('infografis.manage.index', compact('infografis'));
    }

    public function create()
    {
        return view('infografis.manage.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB max
        ]);

        $fotoPaths = [];
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('infografis', 'public');
                $fotoPaths[] = $path;
            }
        }

        Infografis::create([
            'nama' => $request->nama,
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('manage.infografis.index')->with('success', 'Infografis berhasil ditambahkan.');
    }

    public function edit(Infografis $infografi) // Route Model Binding: parameter is $infografi for singular
    {
        return view('infografis.manage.edit', compact('infografi'));
    }

    public function update(Request $request, Infografis $infografi)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'remove_fotos' => 'nullable|array',
        ]);

        $fotoPaths = $infografi->foto ?? [];

        // Handle deletions
        if ($request->has('remove_fotos')) {
            foreach ($request->remove_fotos as $pathToRemove) {
                if (($key = array_search($pathToRemove, $fotoPaths)) !== false) {
                    unset($fotoPaths[$key]);
                    Storage::disk('public')->delete($pathToRemove);
                }
            }
            // Re-index array
            $fotoPaths = array_values($fotoPaths);
        }

        // Handle new uploads
        if ($request->hasFile('foto')) {
            foreach ($request->file('foto') as $file) {
                $path = $file->store('infografis', 'public');
                $fotoPaths[] = $path;
            }
        }

        $infografi->update([
            'nama' => $request->nama,
            'foto' => $fotoPaths,
        ]);

        return redirect()->route('manage.infografis.index')->with('success', 'Infografis berhasil diperbarui.');
    }

    public function destroy(Infografis $infografi)
    {
        // Delete all photos
        if (!empty($infografi->foto)) {
            foreach ($infografi->foto as $path) {
                Storage::disk('public')->delete($path);
            }
        }

        $infografi->delete();

        return redirect()->route('manage.infografis.index')->with('success', 'Infografis berhasil dihapus.');
    }
}
