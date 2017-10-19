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
    Route::group(['prefix' => 'collect'], function () {
        Route::get('test', function () {
            $service = app()->make(\App\Components\Vault\Fractional\Services\Collector\CollectorServiceContract::class);

            $statementID             = $service
                ->collect(300);

            $statementResignedTermID = $service
                ->assignTerm(6, 10)
                ->change($statementID->id, 300);

            $statementWithTermID     = $service
                ->assignTerm(12, 10)
                ->collect(500);

            $statementResignedID     = $service
                ->change($statementID->id, 1000);

            return response()->json([
                $statementID->id,
                $statementWithTermID->id,
                $statementResignedID->id,
                $statementResignedTermID->id,
                $service->view($statementResignedTermID->id)
            ]);
        });
    });

    Route::group(['prefix' => 'pay'], function () {
        Route::get('test', function () {
            $serviceCollector = app()->make(\App\Components\Vault\Fractional\Services\Collector\CollectorServiceContract::class);
            $agreement        = $serviceCollector->assignTerm(12, 10)->collect(500);

            $serviceWallet = app()->make(\App\Components\Vault\Outbound\Services\Collector\CollectorService::class);
            $payment       = $serviceWallet->collect('outwear', 200);

            $serviceWarden = app()->make(\App\Components\Vault\Fractional\Services\Warden\WardenServiceContract::class);
            $agreement     = $serviceWarden->charge($agreement, $payment);

            return response()->json($agreement->toArray());
        });
    });
});


Route::group(['prefix' => 'inbound'], function () {
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('test', function () {

            $service = app()->make(\App\Components\Vault\Inbound\Services\Collector\CollectorService::class);

            $statementID             = $service
                ->collect('salary', 3000);

            $statementIDChanged      = $service
                ->change($statementID->id, 2000);

            return response()->json([
                $statementID->id,
                $statementIDChanged->id,
                $service->view($statementIDChanged->id),
                $service->refund($statementID->id)
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
                ->change($statementID->id, 300);

            return response()->json([
                $statementID->id,
                $statementIDChanged->id,
                $service->view($statementIDChanged->id),
                $service->refund($statementID->id)
            ]);
        });
    });
});
