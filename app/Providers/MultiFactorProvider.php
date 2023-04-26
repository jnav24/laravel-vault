<?php

namespace App\Providers;

use App\Services\MultiFactorService;
use Illuminate\Support\ServiceProvider;
use PragmaRX\Google2FA\Google2FA;

class MultiFactorProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(MultiFactorService::class, function ($app) {
            return new MultiFactorService(new Google2FA());
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
