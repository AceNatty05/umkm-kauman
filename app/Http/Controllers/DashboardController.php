<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->isAdmin()) {
            $totalUmkm = Umkm::count();
            $totalProducts = \App\Models\Product::count();
            $totalUsers = \App\Models\User::count();
            $recentUmkm = Umkm::with('user')->latest()->take(5)->get();
        } else {
            $totalUmkm = $user->umkms()->count();
            $totalProducts = \App\Models\Product::whereIn('umkm_id', $user->umkms()->pluck('id'))->count();
            $totalUsers = null;
            $recentUmkm = $user->umkms()->latest()->take(5)->get();
        }

        return view('dashboard', compact('totalUmkm', 'totalProducts', 'totalUsers', 'recentUmkm'));
    }
}
