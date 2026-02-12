<?php

namespace App\Providers;

use App\Services\PaymentService;
use Illuminate\Support\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(PaymentService::class, function ($app) {
            // You can inject the gateway type dynamically or use a config value
            $gateway = config('payment.gateway', 'stripe'); // Default to 'stripe'
            return new PaymentService($gateway);
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
