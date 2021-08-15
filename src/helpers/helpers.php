<?php

use Illuminate\Support\Facades\Config;

/**
 * get database tables prefix
 * @return mixed|string
 */
function lsl_db_pfx()
{
    return Config::has('laravel-scenario-logger.db-pfx') ? Config::get('laravel-scenario-logger.db-pfx') : '';
}

function lsl_is_active()
{
    return Config::has('laravel-scenario-logger.is_active') ? Config::get('laravel-scenario-logger.is_active') : '';
}

function lsl_service_is_active($serviceKey): bool
{
    $activeServices = Config::get('laravel-scenario-logger.active-services');
    if (in_array($serviceKey, $activeServices)) {
        return true;
    }
    return false;
}

