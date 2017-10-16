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

Route::group(['prefix' => 'installment'], function () {
    Route::get('test', function () {

        $service = app()->make(\App\Components\Vault\Installment\Services\Collector\CollectorServiceContract::class);

        $statementID             = $service
            ->signStatement(300);

        $statementResignedTermID = $service
            ->signTerm(6, 10)
            ->resignStatement($statementID, 300);

        $statementWithTermID     = $service
            ->signTerm(12, 10)
            ->signStatement(500);

        $statementResignedID     = $service
            ->resignStatement($statementID, 1000);

        return response()->json([
            $statementID,
            $statementWithTermID,
            $statementResignedID,
            $statementResignedTermID,
            $service->viewStatement($statementResignedTermID)
        ]);
    });
});


Route::group(['prefix' => 'incoming'], function () {
    Route::group(['prefix' => 'wallet'], function () {
        Route::get('test', function () {

            $service = app()->make(\App\Components\Vault\Inbound\Services\Collector\CollectorService::class);

            $statementID             = $service
                ->collect('salary', 3000);

            $statementIDChanged      = $service
                ->change($statementID, 2000);


            return response()->json([
                $statementID,
                $statementIDChanged,
                $service->view($statementIDChanged),
                $service->refund($statementID)
            ]);
        });
    });

});
