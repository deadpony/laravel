<?php

namespace App\Components\Waster\Expenses\Provide;

use App\Components\Waster\Expenses\Entities\CoinEntity;
use App\Components\Waster\Expenses\Entities\Contracts\CoinContract;
use App\Components\Waster\Expenses\Models\CoinModel;
use App\Components\Waster\Expenses\Repositories\Contracts\RepositoryContract;
use App\Components\Waster\Expenses\Repositories\EloquentRepository;
use App\Helpers\Models\Contracts\Model;
use Illuminate\Support\ServiceProvider;

class ExpensesServiceProvider extends ServiceProvider
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
            RepositoryContract::class,
            EloquentRepository::class);

        $this->app->bind(
            CoinContract::class,
            CoinEntity::class);

        $this->app->when(EloquentRepository::class)
            ->needs(Model::class)
            ->give(function () {
                return $this->app->make(CoinModel::class);
            });
    }
}