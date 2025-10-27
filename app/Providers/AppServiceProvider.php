<?php

namespace App\Providers;

use App\Models\Portfolio;
use App\Policies\PortfolioPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL; // <-- Tambahkan ini
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // --- Gabungan dari kedua method boot() Anda ---

        // 1. Dari method boot() pertama Anda (Pendaftaran Policy)
        Gate::policy(Portfolio::class, PortfolioPolicy::class);

        // 2. Dari method boot() kedua Anda (Force HTTPS di Produksi)
        if ($this->app->environment('production')) {
            URL::forceScheme('https'); // <-- Perbaiki salah ketik
        }

        // 3. (REKOMENDASI) Macro notifikasi dari chat kita sebelumnya
        // Ini akan mendaftarkan ->withSuccess() dan ->withError()
        $this->registerFlashMacros();
    }

    /**
     * Helper untuk mendaftarkan macro notifikasi.
     * Ini hanya untuk merapikan method boot() di atas.
     */
    protected function registerFlashMacros(): void
    {
        RedirectResponse::macro('withSuccess', function ($message, $title = 'Berhasil') {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->with('flash', [
                'type' => 'success',
                'title' => $title,
                'message' => $message,
            ]);
        });

        RedirectResponse::macro('withError', function ($message, $title = 'Terjadi Kesalahan') {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->with('flash', [
                'type' => 'error',
                'title' => $title,
                'message' => $message,
            ]);
        });

        RedirectResponse::macro('withWarning', function ($message, $title = 'Peringatan') {
            /** @var \Illuminate\Http\RedirectResponse $this */
            return $this->with('flash', [
                'type' => 'warning',
                'title' => $title,
                'message' => $message,
            ]);
        });
    }
}
