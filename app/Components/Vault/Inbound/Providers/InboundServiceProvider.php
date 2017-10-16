<?php

namespace App\Components\Vault\Installment\Providers;

use App\Components\Vault\Inbound\Wallet\Repositories\WalletRepositoryContract;
use App\Components\Vault\Inbound\Wallet\Repositories\WalletRepositoryDoctrine;
use App\Components\Vault\Inbound\Wallet\WalletContract;
use App\Components\Vault\Inbound\Wallet\WalletEntity;
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
            WalletContract::class,
            WalletEntity::class);

        $this->app->bind(
            WalletRepositoryContract::class,
            WalletRepositoryDoctrine::class);
    }
}