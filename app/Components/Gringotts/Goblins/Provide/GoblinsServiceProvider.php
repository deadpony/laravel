<?php

namespace App\Components\Gringotts\Goblins\Provide;

use App\Components\Gringotts\Goblins\Entities\Account\AccountEntity;
use App\Components\Gringotts\Goblins\Entities\Account\Contracts\AccountContract;
use App\Components\Gringotts\Goblins\Entities\Account\Term\Contracts\TermContract;
use App\Components\Gringotts\Goblins\Entities\Account\Term\TermEntity;
use App\Components\Gringotts\Goblins\Models\Account\AccountModel;
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
            TermContract::class,
            TermEntity::class
        );

        $this->app->bind(
            \App\Components\Gringotts\Goblins\Repositories\Accounts\Contracts\RepositoryContract::class,
            \App\Components\Gringotts\Goblins\Repositories\Accounts\EloquentRepository::class
        );
    }
}