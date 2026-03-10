<?php

namespace Tpjasar\ApiFoundation;

use Illuminate\Support\ServiceProvider;

class ApiFoundationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api-foundation.php', 'api-foundation');
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/api-foundation.php' => config_path('api-foundation.php'),
            ], 'api-foundation-config');
        }
    }
}
