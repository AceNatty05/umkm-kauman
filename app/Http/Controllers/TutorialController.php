<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TutorialController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Tutorial::where('is_published', true);

        if (!$user) {
            // Guest hanya bisa melihat tutorial umum
            $query->where('target_role', 'all');
        } elseif ($user->isAdmin()) {
            // Admin bisa melihat semua
            // Bisa difilter jika ingin hanya menampilkan 'all' dan 'admin'
            // $query->whereIn('target_role', ['all', 'admin']); 
        } else {
            // User (UMKM) bisa melihat 'all' dan 'user'
            $query->whereIn('target_role', ['all', 'user']);
        }

        $tutorials = $query->latest()->paginate(9);

        return view('tutorials.index', compact('tutorials'));
    }

    public function show(Tutorial $tutorial)
    {
        if (!$tutorial->is_published) {
            abort(404);
        }

        Gate::authorize('view-tutorial', $tutorial);

        return view('tutorials.show', compact('tutorial'));
    }
}
