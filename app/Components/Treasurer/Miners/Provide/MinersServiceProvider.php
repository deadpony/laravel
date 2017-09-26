<?php

namespace App\Components\Treasurer\Miners\Provide;

use App\Components\Treasurer\Miners\Models\CoinModel;
use App\Components\Treasurer\Miners\Repositories\Contracts\CoinContract;
use App\Components\Treasurer\Miners\Repositories\Contracts\RepositoryContract;
use App\Components\Treasurer\Miners\Repositories\EloquentRepository;
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
        $this->app->bind(CoinContract::class, CoinModel::class);
        $this->app->bind(RepositoryContract::class, EloquentRepository::class);
    }
}