<?php

namespace App\Components\Gringotts\Goblins\Provide;

use App\Components\Gringotts\Goblins\Entities\AccountEntity;
use App\Components\Gringotts\Goblins\Entities\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Entities\Contracts\TermContract;
use App\Components\Gringotts\Goblins\Entities\TermEntity;
use App\Components\Gringotts\Goblins\Models\AccountModel;
use App\Components\Gringotts\Goblins\Models\TermModel;
use App\Helpers\Models\Contracts\Model;
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
            AccountEntity::class
        );

        $this->app->bind(
            \App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract::class,
            \App\Components\Gringotts\Goblins\Repositories\Accounts\EloquentRepository::class
        );

        $this->app->when(\App\Components\Gringotts\Goblins\Repositories\Accounts\EloquentRepository::class)
            ->needs(Model::class)
            ->give(function () {
                return $this->app->make(AccountModel::class);
            });

        $this->app->bind(
            TermContract::class,
            TermEntity::class
        );

        $this->app->bind(
            \App\Components\Gringotts\Goblins\Repositories\Terms\Contracts\RepositoryContract::class,
            \App\Components\Gringotts\Goblins\Repositories\Terms\EloquentRepository::class
        );

        $this->app->when(\App\Components\Gringotts\Goblins\Repositories\Terms\EloquentRepository::class)
            ->needs(Model::class)
            ->give(function () {
                return $this->app->make(TermModel::class);
            });
    }
}