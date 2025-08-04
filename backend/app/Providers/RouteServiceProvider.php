<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected $apiv1Namespace = 'App\Http\Controllers\api\v1';

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
{
    $this->routes(function () {
        Route::middleware('api')
            ->prefix('api/v1')
            ->namespace($this->apiv1Namespace)
            ->group(base_path('routes/api_v1.php'));

        // Default Laravel route file
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));
    });
}

}
