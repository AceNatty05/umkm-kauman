<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class UserManagementController extends Controller
{
    /**
     * Daftar semua user (admin only).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        $users = User::when($search, function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('manage.users.index', compact('users', 'search'));
    }

    /**
     * Form tambah user baru.
     */
    public function create()
    {
        return view('manage.users.create');
    }

    /**
     * Simpan user baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone',
            'email' => 'nullable|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::defaults()],
            'role' => 'required|in:admin,user',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'password' => $validated['password'],
            'role' => $validated['role'],
            'phone_verified' => true, // Admin-created accounts are pre-verified
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Form edit user.
     */
    public function edit(User $user)
    {
        return view('manage.users.edit', compact('user'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:users,phone,' . $user->id,
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,user',
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'role' => $validated['role'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $user->update($updateData);

        return redirect()->route('users.index')
            ->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Hapus user.
     */
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Tidak bisa menghapus akun sendiri.']);
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
