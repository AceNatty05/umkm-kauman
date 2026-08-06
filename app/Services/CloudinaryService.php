<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class CloudinaryService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => config('services.cloudinary.cloud_name'),
                    'api_key' => config('services.cloudinary.api_key'),
                    'api_secret' => config('services.cloudinary.api_secret'),
                ],
                'url' => [
                    'secure' => true,
                ],
            ])
        );
    }

    /**
     * Upload file ke Cloudinary.
     *
     * @param UploadedFile $file File yang diupload
     * @param string $folder Folder di Cloudinary (misal: 'umkm', 'products', 'users')
     * @return string|null URL foto yang diupload
     */
    public function upload(UploadedFile $file, string $folder = 'umkm'): ?string
    {
        try {
            $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
                'folder' => "umkm-kauman/{$folder}",
                'transformation' => [
                    'quality' => 'auto',
                    'fetch_format' => 'auto',
                ],
            ]);

            return $result['secure_url'];
        } catch (\Exception $e) {
            Log::error("Cloudinary upload error: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Hapus file dari Cloudinary berdasarkan URL.
     */
    public function delete(string $url): bool
    {
        try {
            // Extract public_id dari URL
            $publicId = $this->extractPublicId($url);
            if ($publicId) {
                $this->cloudinary->uploadApi()->destroy($publicId);
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error("Cloudinary delete error: " . $e->getMessage());
            return false;
        }
    }

    private function extractPublicId(string $url): ?string
    {
        // URL format: https://res.cloudinary.com/xxx/image/upload/v123/folder/filename.ext
        if (preg_match('/\/upload\/(?:v\d+\/)?(.+)\.[^.]+$/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
