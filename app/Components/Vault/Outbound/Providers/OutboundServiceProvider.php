<?php

namespace App\Components\Vault\Outbound\Providers;

use App\Components\Vault\Outbound\Services\Collector\CollectorService;
use App\Components\Vault\Outbound\Services\Collector\CollectorServiceContract;
use App\Components\Vault\Outbound\Wallet\Repositories\WalletRepositoryContract;
use App\Components\Vault\Outbound\Wallet\Repositories\WalletRepositoryDoctrine;
use App\Components\Vault\Outbound\Wallet\WalletContract;
use App\Components\Vault\Outbound\Wallet\WalletEntity;
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
            WalletContract::class,
            WalletEntity::class);

        $this->app->bind(
            WalletRepositoryContract::class,
            WalletRepositoryDoctrine::class);

        $this->app->bind(
            CollectorServiceContract::class,
            CollectorService::class
        );
    }
}