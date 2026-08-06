<?php

namespace App\Services\WhatsApp;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Driver untuk production — OTP dikirim via Fonnte.com API.
 *
 * Setup:
 * 1. Daftar di https://fonnte.com
 * 2. Dapatkan API Token dari dashboard
 * 3. Set di .env: FONNTE_API_TOKEN=your_token
 * 4. Set di .env: WHATSAPP_DRIVER=fonnte
 */
class FonnteWhatsAppService implements WhatsAppServiceInterface
{
    private string $apiToken;
    private string $apiUrl = 'https://api.fonnte.com/send';

    public function __construct()
    {
        $this->apiToken = config('services.fonnte.api_token', '');
    }

    public function sendMessage(string $phone, string $message): bool
    {
        if (empty($this->apiToken)) {
            Log::error('Fonnte API Token belum diset. Set FONNTE_API_TOKEN di .env');
            return false;
        }

        // Normalisasi nomor telepon ke format 628xxx
        $phone = $this->normalizePhone($phone);

        try {
            $response = Http::withHeaders([
                'Authorization' => $this->apiToken,
            ])->post($this->apiUrl, [
                'target' => $phone,
                'message' => $message,
            ]);

            if ($response->successful() && $response->json('status') === true) {
                Log::info("WhatsApp OTP terkirim ke {$phone} via Fonnte");
                return true;
            }

            Log::error("Gagal kirim WhatsApp via Fonnte: " . $response->body());
            return false;
        } catch (\Exception $e) {
            Log::error("Exception saat kirim WhatsApp via Fonnte: " . $e->getMessage());
            return false;
        }
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '62' . substr($phone, 1);
        }
        return $phone;
    }
}
