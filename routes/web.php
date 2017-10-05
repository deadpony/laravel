<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    $repo = app()->make(\App\Components\Vault\Incoming\Statement\Repositories\StatementRepositoryContract::class);

    $statement = $repo->byIdentity(new \App\Convention\ValueObjects\Identity\Identity('0abbf7b8-2f32-4873-b755-f6ba97429f29'));

    try {
        $statement->assignTerm(
            new \App\Components\Vault\Incoming\Statement\Term\TermEntity(
                \App\Convention\Generators\Identity\IdentityGenerator::next(),
                8,
                $statement
            )
        );
    } catch (\InvalidArgumentException $ex) {
        $statement->destroyTerm();
    }

    $repo->persist($statement);

    dd($statement);

});

Route::group(['prefix' => 'treasurer'], function () {
    Route::get('test', function () {
        $treasurer = new \App\Components\Treasurer\MasterTreasurer();
        return response()->json($treasurer->salary()->earn(20)->getID());
    });
});

Route::group(['prefix' => 'waster'], function () {
    Route::get('test', function () {
        $waster = new App\Components\Waster\MasterWaster();
        return response()->json($waster->food()->charge(20)->getID());
    });
});

Route::group(['prefix' => 'gringotts'], function () {
    Route::get('test', function () {
        $gringotts = new App\Components\Gringotts\MasterGringotts();

        $account   = $gringotts->credit()->open('300');
        $account   = $gringotts->credit()->acceptTerm(
            $account,
            6,
            \Carbon\Carbon::now()
        );

        $account   = $gringotts->credit()->view(6);
        $account   = $gringotts->credit()->acceptTerm(
            $account,
            12,
            \Carbon\Carbon::now()
        );
        return response()->json($account->getTerm()->set());
    });
});


