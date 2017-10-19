<?php

namespace App\Components\Vault\Inbound\Providers;

use App\Components\Vault\Inbound\Services\Collector\CollectorService;
use App\Components\Vault\Inbound\Services\Collector\CollectorServiceContract;
use App\Components\Vault\Inbound\Payment\Repositories\PaymentRepositoryContract;
use App\Components\Vault\Inbound\Payment\Repositories\PaymentRepositoryDoctrine;
use App\Components\Vault\Inbound\Payment\PaymentContract;
use App\Components\Vault\Inbound\Payment\PaymentEntity;
use Illuminate\Support\ServiceProvider;

class InboundServiceProvider extends ServiceProvider
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