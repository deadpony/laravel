<?php

namespace App\Components\Vault\Installment\Providers;

use App\Components\Vault\Installment\Services\Collector\CollectorService;
use App\Components\Vault\Installment\Services\Collector\CollectorServiceContract;
use App\Components\Vault\Installment\Statement\Repositories\StatementRepositoryContract;
use App\Components\Vault\Installment\Statement\Repositories\StatementRepositoryDoctrine;
use App\Components\Vault\Installment\Statement\StatementContract;
use App\Components\Vault\Installment\Statement\StatementEntity;
use App\Components\Vault\Installment\Statement\Term\TermContract;
use App\Components\Vault\Installment\Statement\Term\TermEntity;
use Illuminate\Support\ServiceProvider;

class VaultIncomingServiceProvider extends ServiceProvider
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
            StatementContract::class,
            StatementEntity::class);
        $this->app->bind(
            TermContract::class,
            TermEntity::class);
        $this->app->bind(
            StatementRepositoryContract::class,
            StatementRepositoryDoctrine::class);

        $this->app->bind(
            CollectorServiceContract::class,
            CollectorService::class);
    }
}