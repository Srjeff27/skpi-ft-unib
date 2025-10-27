<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Portfolio;
use App\Policies\PortfolioPolicy;

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
        if ($this->app->environment('production')) {
        \URL::forceScheme('https');

        
        // Register policies (explicit to ensure authorization works without AuthServiceProvider)
        Gate::policy(Portfolio::class, PortfolioPolicy::class);
        
    }
    }


}
