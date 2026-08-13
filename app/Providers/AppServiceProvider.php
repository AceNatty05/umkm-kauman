<?php

namespace App\Providers;

use App\Services\WhatsApp\FonnteWhatsAppService;
use App\Services\WhatsApp\LogWhatsAppService;
use App\Services\WhatsApp\WhatsAppServiceInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bind WhatsApp driver berdasarkan konfigurasi .env
        $this->app->singleton(WhatsAppServiceInterface::class, function () {
            return match (config('services.whatsapp.driver', 'log')) {
                'fonnte' => new FonnteWhatsAppService(),
                default => new LogWhatsAppService(),
            };
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Admin bypass semua Gate checks
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
            return null;
        });

        // Gate untuk manajemen user (admin only)
        Gate::define('manage-users', function ($user) {
            return $user->isAdmin();
        });

        // Gate untuk melihat tutorial
        Gate::define('view-tutorial', function (?\App\Models\User $user, \App\Models\Tutorial $tutorial) {
            // Jika tutorial untuk semua orang, izinkan (termasuk guest)
            if ($tutorial->target_role === 'all') {
                return true;
            }

            // Jika belum login, tolak akses ke tutorial khusus
            if (!$user) {
                return false;
            }

            // Jika target_role adalah 'user', pastikan user adalah pelaku UMKM (user biasa)
            if ($tutorial->target_role === 'user' && $user->isUser()) {
                return true;
            }

            // Admin sudah dibypass di Gate::before di atas, jadi jika sampai di sini untuk admin, 
            // sebenarnya sudah tidak dieksekusi, tapi amannya kita kembalikan false jika tidak memenuhi syarat.
            return false;
        });
    }
}
