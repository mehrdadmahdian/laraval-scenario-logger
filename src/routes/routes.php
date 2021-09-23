<?php

use Escherchia\LaravelScenarioLogger\Controllers\LaravelScenarioLoggerController;
use Illuminate\Support\Facades\Route;

Route::get('laravel-scenario-logger', LaravelScenarioLoggerController::class.'@index');
Route::get('laravel-scenario-logger/{id}', LaravelScenarioLoggerController::class.'@show');