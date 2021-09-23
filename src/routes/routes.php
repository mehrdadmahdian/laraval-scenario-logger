<?php

use Escherchia\LaravelScenarioLogger\Controllers\LaravelScenarioLoggerController;
use Illuminate\Support\Facades\Route;

Route::get('laravel-scenario-logger', LaravelScenarioLoggerController::class.'@index')->name('lsl-datatable.index');
Route::get('laravel-scenario-logger/data', LaravelScenarioLoggerController::class.'@data')->name('lsl-datatable.data');
Route::get('laravel-scenario-logger/{id}', LaravelScenarioLoggerController::class.'@show');
