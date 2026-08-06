<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Log;

/**
 * Driver untuk development — OTP ditampilkan di log file.
 * Tidak perlu akun WhatsApp API apapun.
 *
 * Cek OTP di: storage/logs/laravel.log
 */
class LogWhatsAppService implements WhatsAppServiceInterface
{
    public function sendMessage(string $phone, string $message): bool
    {
        Log::channel('single')->info("=== WHATSAPP OTP (DEV MODE) ===");
        Log::channel('single')->info("Ke: {$phone}");
        Log::channel('single')->info("Pesan: {$message}");
        Log::channel('single')->info("================================");

        return true;
    }
}
