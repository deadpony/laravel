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

Route::group(['prefix' => 'fractional'], function () {
    Route::get('test', function () {

        $service = app()->make(\App\Components\Vault\Fractional\Services\Collector\CollectorServiceContract::class);

        $statementID             = $service
            ->collect(300);

        $statementResignedTermID = $service
            ->assignTerm(6, 10)
            ->change($statementID->identity, 300);

        $statementWithTermID     = $service
            ->assignTerm(12, 10)
            ->collect(500);

        $statementResignedID     = $service
            ->change($statementID->identity, 1000);

        return response()->json([
            $statementID->identity,
            $statementWithTermID->identity,
            $statementResignedID->identity,
            $statementResignedTermID->identity,
            $service->view($statementResignedTermID->identity)
        ]);
    });
});


Route::group(['prefix' => 'inbound'], function () {
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('test', function () {

            $service = app()->make(\App\Components\Vault\Inbound\Services\Collector\CollectorService::class);

            $statementID             = $service
                ->collect('salary', 3000);

            $statementIDChanged      = $service
                ->change($statementID->identity, 2000);

            return response()->json([
                $statementID->identity,
                $statementIDChanged->identity,
                $service->view($statementIDChanged->identity),
                $service->refund($statementID->identity)
            ]);
        });
    });
});

Route::group(['prefix' => 'outbound'], function () {
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('test', function () {

            $service = app()->make(\App\Components\Vault\Outbound\Services\Collector\CollectorService::class);

            $statementID             = $service
                ->collect('outwear', 200);

            $statementIDChanged      = $service
                ->change($statementID->identity, 300);

            return response()->json([
                $statementID->identity,
                $statementIDChanged->identity,
                $service->view($statementIDChanged->identity),
                $service->refund($statementID->identity)
            ]);
        });
    });
});
