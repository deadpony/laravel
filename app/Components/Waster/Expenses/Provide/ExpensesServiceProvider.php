<?php

namespace App\Components\Waster\Expenses\Provide;

use App\Components\Waster\Expenses\Models\CoinModel;
use App\Components\Waster\Expenses\Repositories\Contracts\CoinContract;
use App\Components\Waster\Expenses\Repositories\Contracts\RepositoryContract;
use App\Components\Waster\Expenses\Repositories\EloquentRepository;
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
        $this->app->bind(CoinContract::class, CoinModel::class);
        $this->app->bind(RepositoryContract::class, EloquentRepository::class);
    }
}