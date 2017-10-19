<?php

namespace App\Components\Vault\Outbound\Providers;

use App\Components\Vault\Outbound\Services\Collector\CollectorService;
use App\Components\Vault\Outbound\Services\Collector\CollectorServiceContract;
use App\Components\Vault\Outbound\Payment\Repositories\PaymentRepositoryContract;
use App\Components\Vault\Outbound\Payment\Repositories\PaymentRepositoryDoctrine;
use App\Components\Vault\Outbound\Payment\PaymentContract;
use App\Components\Vault\Outbound\Payment\PaymentEntity;
use Illuminate\Support\ServiceProvider;

class OutboundServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            PaymentContract::class,
            PaymentEntity::class);

        $this->app->bind(
            PaymentRepositoryContract::class,
            PaymentRepositoryDoctrine::class);

        $this->app->bind(
            CollectorServiceContract::class,
            CollectorService::class
        );
    }
}