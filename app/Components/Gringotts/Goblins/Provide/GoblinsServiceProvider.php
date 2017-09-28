<?php

namespace App\Components\Gringotts\Goblins\Provide;

use App\Components\Gringotts\Goblins\Models\AccountModel;
use App\Components\Gringotts\Goblins\Models\TermModel;
use App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\TermContract;
use Illuminate\Support\ServiceProvider;

class GoblinsServiceProvider extends ServiceProvider
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
            AccountContract::class,
            AccountModel::class
        );

        $this->app->bind(
            \App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract::class,
            \App\Components\Gringotts\Goblins\Repositories\Accounts\EloquentRepository::class
        );

        $this->app->bind(
            TermContract::class,
            TermModel::class

        );

        $this->app->bind(
            \App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\RepositoryContract::class,
            \App\Components\Gringotts\Goblins\Repositories\Terms\EloquentRepository::class
        );
    }
}