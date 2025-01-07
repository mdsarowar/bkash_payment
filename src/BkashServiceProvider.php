<?php

namespace Sarowar\Bkash;

use Illuminate\Support\ServiceProvider;
use Sarowar\Bkash\Services\BkashManager;

class BkashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {

        $this->publishes([
            __DIR__ . '/Controllers/PaymentController.php' => app_path('Http/Controllers/PaymentController.php'),
        ], 'controllers');

        $this->publishes([
            __DIR__ . '/config/bkash_payment.php' => config_path('bkash_payment.php'),
        ], 'config');

        $this->loadRoutesFrom(__DIR__ . '/routes/bkash_route.php');


        $this->loadViewsFrom(__DIR__ . '/views', 'bkash');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // Bind services or configurations here if needed.
        $this->app->singleton('bkash', function ($app) {
            return new BkashManager();
        });

        $this->mergeConfigFrom(
            __DIR__ . '/config/bkash_payment.php',
            'bkash'
        );
    }
}
