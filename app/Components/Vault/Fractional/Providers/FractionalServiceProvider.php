<?php

namespace App\Components\Vault\Fractional\Providers;

use App\Components\Vault\Fractional\Services\Collector\CollectorService;
use App\Components\Vault\Fractional\Services\Collector\CollectorServiceContract;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryContract;
use App\Components\Vault\Fractional\Agreement\Repositories\AgreementRepositoryDoctrine;
use App\Components\Vault\Fractional\Agreement\AgreementContract;
use App\Components\Vault\Fractional\Agreement\AgreementEntity;
use App\Components\Vault\Fractional\Agreement\Term\TermContract;
use App\Components\Vault\Fractional\Agreement\Term\TermEntity;
use App\Components\Vault\Fractional\Services\Warden\WardenService;
use App\Components\Vault\Fractional\Services\Warden\WardenServiceContract;
use Illuminate\Support\ServiceProvider;

class FractionalServiceProvider extends ServiceProvider
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
            AgreementContract::class,
            AgreementEntity::class);

        $this->app->bind(
            TermContract::class,
            TermEntity::class);

        $this->app->bind(
            AgreementRepositoryContract::class,
            AgreementRepositoryDoctrine::class);

        $this->app->bind(
            CollectorServiceContract::class,
            CollectorService::class);

        $this->app->bind(
            WardenServiceContract::class,
            WardenService::class);
    }
}