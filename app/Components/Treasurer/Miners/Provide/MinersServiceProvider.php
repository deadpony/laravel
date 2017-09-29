<?php

namespace App\Components\Treasurer\Miners\Provide;

use App\Components\Treasurer\Miners\Entities\CoinEntity;
use App\Components\Treasurer\Miners\Entities\Contracts\CoinContract;
use App\Components\Treasurer\Miners\Models\CoinModel;
use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use App\Components\Treasurer\Miners\Repositories\EloquentRepository;
use App\Helpers\Models\Contracts\Model;
use Illuminate\Support\ServiceProvider;

class MinersServiceProvider extends ServiceProvider
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