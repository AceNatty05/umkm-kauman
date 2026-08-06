<?php

namespace App\Http\Controllers;

use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(private CloudinaryService $cloudinary)
    {
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request)
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photoUrl = $this->cloudinary->upload($request->file('photo'), 'users');
            if ($photoUrl) {
                if ($user->photo) {
                    $this->cloudinary->delete($user->photo);
                }
                $validated['photo'] = $photoUrl;
            }
        }

        $user->update($validated);

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
