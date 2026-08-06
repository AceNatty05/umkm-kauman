<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Tampilkan form registrasi.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Step 1: Validasi data & kirim OTP.
     */
    public function store(Request $request, OtpService $otpService)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20', 'unique:users,phone'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'phone.required' => 'Nomor WhatsApp wajib diisi.',
            'phone.unique' => 'Nomor WhatsApp sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Simpan data registrasi di session
        $request->session()->put('registration_data', [
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => $request->password,
        ]);

        // Kirim OTP
        $result = $otpService->sendOtp($request->phone, 'register');

        if (!$result['success']) {
            return back()->withErrors(['phone' => $result['message']])->withInput();
        }

        // Redirect ke halaman verifikasi OTP
        return redirect()->route('otp.verify')
            ->with('otp_message', $result['message'])
            ->with('debug_otp', $result['debug_otp'] ?? null);
    }
}
