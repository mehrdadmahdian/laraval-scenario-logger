<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;

/**
 * @return \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed|null
 * @throws Throwable
 */
function lsl_is_active()
{
    $value = config('laravel-scenario-logger.is_active');

    throw_if( is_null($value) or !is_bool($value), new \Escherchia\LaravelScenarioLogger\Exceptions\BadConfigException() );
    return $value;
}

/**
 * @param $serviceKey
 * @return bool
 */
function lsl_service_is_active($serviceKey): bool
{
    $activeServices = config('laravel-scenario-logger.active-services');
    if (in_array($serviceKey, $activeServices)) {
        return true;
    }

    return false;
}

function lsl_active_services()
{
    $services = config('laravel-scenario-logger.service-configuration', []);
    $activeServices = Arr::where($services, function($item) {
        return Arr::get($item, 'active', true);
    });
    
    return $activeServices;
}
