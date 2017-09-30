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
        return response()->json($gringotts->credit()->open('300')->getID());
    });
});


