<?php

namespace App\Services\WhatsApp;

interface WhatsAppServiceInterface
{
    /**
     * Kirim pesan WhatsApp ke nomor tujuan.
     *
     * @param string $phone Nomor WA tujuan (format: 08xxx atau 628xxx)
     * @param string $message Isi pesan
     * @return bool Berhasil atau tidak
     */
    public function sendMessage(string $phone, string $message): bool;
}
