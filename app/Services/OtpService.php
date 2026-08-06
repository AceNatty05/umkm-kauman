<?php

namespace App\Services;

use App\Models\OtpCode;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class OtpService
{
    public function __construct(
        private WhatsAppServiceInterface $whatsAppService
    ) {}

    /**
     * Generate dan kirim OTP ke nomor WA.
     */
    public function sendOtp(string $phone, string $type = 'register'): array
    {
        // Cek rate limit: max request per 5 menit
        $recentCount = OtpCode::where('phone', $phone)
            ->where('type', $type)
            ->where('created_at', '>=', now()->subMinutes(5))
            ->count();

        $maxRequests = config('otp.max_requests_per_5min', 3);
        if ($recentCount >= $maxRequests) {
            return [
                'success' => false,
                'message' => 'Terlalu banyak permintaan OTP. Coba lagi dalam beberapa menit.',
            ];
        }

        // Cek cooldown: minimal 60 detik antar request
        $lastOtp = OtpCode::where('phone', $phone)
            ->where('type', $type)
            ->latest()
            ->first();

        $cooldown = config('otp.cooldown_seconds', 60);
        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < $cooldown) {
            $remaining = $cooldown - $lastOtp->created_at->diffInSeconds(now());
            return [
                'success' => false,
                'message' => "Tunggu {$remaining} detik sebelum meminta OTP baru.",
            ];
        }

        // Generate OTP
        $otpLength = config('otp.length', 6);
        $otp = str_pad(random_int(0, pow(10, $otpLength) - 1), $otpLength, '0', STR_PAD_LEFT);

        // Simpan ke database (hashed)
        $otpCode = OtpCode::create([
            'phone' => $phone,
            'code' => Hash::make($otp),
            'type' => $type,
            'expires_at' => now()->addMinutes(config('otp.expiry_minutes', 5)),
        ]);

        // Kirim via WhatsApp
        $appName = config('app.name', 'UMKM Desa Kauman');
        $message = "🔐 *{$appName}*\n\n"
            . "Kode OTP Anda: *{$otp}*\n\n"
            . "Kode berlaku selama " . config('otp.expiry_minutes', 5) . " menit.\n"
            . "Jangan bagikan kode ini kepada siapapun.";

        $sent = $this->whatsAppService->sendMessage($phone, $message);

        if (!$sent) {
            Log::warning("Gagal mengirim OTP ke {$phone}");
        }

        return [
            'success' => true,
            'message' => 'Kode OTP telah dikirim ke WhatsApp Anda.',
            // Hanya untuk development (driver log)
            'debug_otp' => config('app.debug') ? $otp : null,
        ];
    }

    /**
     * Verifikasi kode OTP.
     */
    public function verifyOtp(string $phone, string $code, string $type = 'register'): array
    {
        $otpCode = OtpCode::where('phone', $phone)
            ->where('type', $type)
            ->whereNull('verified_at')
            ->latest()
            ->first();

        if (!$otpCode) {
            return [
                'success' => false,
                'message' => 'Kode OTP tidak ditemukan. Silakan minta OTP baru.',
            ];
        }

        // Cek expired
        if ($otpCode->isExpired()) {
            return [
                'success' => false,
                'message' => 'Kode OTP sudah kedaluwarsa. Silakan minta OTP baru.',
            ];
        }

        // Cek max attempts
        if ($otpCode->hasExceededAttempts()) {
            return [
                'success' => false,
                'message' => 'Terlalu banyak percobaan. Silakan minta OTP baru.',
            ];
        }

        // Verifikasi kode
        if (!Hash::check($code, $otpCode->code)) {
            $otpCode->incrementAttempts();
            $remaining = config('otp.max_attempts', 5) - $otpCode->attempts;
            return [
                'success' => false,
                'message' => "Kode OTP salah. Sisa percobaan: {$remaining}.",
            ];
        }

        // Mark as verified
        $otpCode->update(['verified_at' => now()]);

        return [
            'success' => true,
            'message' => 'Kode OTP berhasil diverifikasi.',
        ];
    }
}
