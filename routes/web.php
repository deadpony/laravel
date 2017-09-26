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
    $salary = app()->make(\App\Components\Treasurer\Miners\SalaryMiner::class);

    $salary->earn(20);

    $salary->change(1,50);

    $salary->refund(2);
});
