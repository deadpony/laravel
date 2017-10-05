<?php

namespace App\Components\Vault\Incoming\Providers;

use App\Components\Vault\Incoming\Statement\Repositories\StatementRepositoryContract;
use App\Components\Vault\Incoming\Statement\Repositories\StatementRepositoryDoctrine;
use App\Components\Vault\Incoming\Statement\StatementContract;
use App\Components\Vault\Incoming\Statement\StatementEntity;
use App\Components\Vault\Incoming\Statement\Term\TermContract;
use App\Components\Vault\Incoming\Statement\Term\TermEntity;
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
    }
}