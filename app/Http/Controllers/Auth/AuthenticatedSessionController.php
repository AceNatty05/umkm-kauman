<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request (phone + password).
     */
    public function store(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        // Attempt login with phone + password
        if (!Auth::attempt(['phone' => $request->phone, 'password' => $request->password], $request->boolean('remember'))) {
            return back()->withErrors([
                'phone' => 'Nomor WhatsApp atau password salah.',
            ])->onlyInput('phone');
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
