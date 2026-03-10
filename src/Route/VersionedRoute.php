<?php

namespace Tpjasar\ApiFoundation\Route;

use Illuminate\Support\Facades\Route;

class VersionedRoute
{
    /**
     * Register versioned API routes. Any version works: /api/v1/..., /api/v2/..., /api/v3/...
     * No config needed to add new versions. Get current version in your handler: request()->route('version')
     *
     * VersionedRoute::register(function () {
     *     Route::get('users', [UserController::class, 'index']);
     * });
     */
    public static function register(callable $callback): void
    {
        $prefix = config('api-foundation.prefix', '');
        $middleware = config('api-foundation.middleware', 'api');
        $middleware = is_array($middleware) ? $middleware : [$middleware];

        $fullPrefix = ($prefix !== '' && $prefix !== null)
            ? $prefix . '/{version}'
            : '{version}';

        Route::prefix($fullPrefix)
            ->where(['version' => 'v\d+'])
            ->middleware($middleware)
            ->group(function () use ($callback) {
                $callback();
            });
    }
}
