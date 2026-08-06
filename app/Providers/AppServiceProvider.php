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
    }
}
