<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OtpController extends Controller
{
    /**
     * Tampilkan form verifikasi OTP.
     */
    public function show(Request $request)
    {
        // Pastikan ada data registrasi di session
        if (!$request->session()->has('registration_data')) {
            return redirect()->route('register')
                ->withErrors(['phone' => 'Silakan isi form registrasi terlebih dahulu.']);
        }

        $phone = $request->session()->get('registration_data.phone');

        return view('auth.verify-otp', [
            'phone' => $phone,
            'debug_otp' => session('debug_otp'),
        ]);
    }

    /**
     * Verifikasi OTP dan buat akun.
     */
    public function verify(Request $request, OtpService $otpService)
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ], [
            'otp.required' => 'Kode OTP wajib diisi.',
            'otp.size' => 'Kode OTP harus 6 digit.',
        ]);

        $registrationData = $request->session()->get('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['phone' => 'Sesi registrasi telah berakhir. Silakan daftar ulang.']);
        }

        // Verifikasi OTP
        $result = $otpService->verifyOtp($registrationData['phone'], $request->otp, 'register');

        if (!$result['success']) {
            return back()->withErrors(['otp' => $result['message']]);
        }

        // Buat akun user
        $user = User::create([
            'name' => $registrationData['name'],
            'phone' => $registrationData['phone'],
            'password' => $registrationData['password'],
            'role' => 'user',
            'phone_verified' => true,
        ]);

        // Hapus data registrasi dari session
        $request->session()->forget('registration_data');

        // Login otomatis
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Selamat datang, ' . $user->name . '! Akun berhasil dibuat.');
    }

    /**
     * Kirim ulang OTP.
     */
    public function resend(Request $request, OtpService $otpService)
    {
        $registrationData = $request->session()->get('registration_data');

        if (!$registrationData) {
            return redirect()->route('register')
                ->withErrors(['phone' => 'Sesi registrasi telah berakhir.']);
        }

        $result = $otpService->sendOtp($registrationData['phone'], 'register');

        if (!$result['success']) {
            return back()->withErrors(['otp' => $result['message']]);
        }

        return back()
            ->with('otp_message', $result['message'])
            ->with('debug_otp', $result['debug_otp'] ?? null);
    }
}
