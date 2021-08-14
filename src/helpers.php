<?php

use Illuminate\Support\Facades\Config;

/**
 * get database tables prefix
 * @return mixed|string
 */
function lsl_db_pfx()
{
    return Config::has('laravel-scenario-logger.dp-pfx') ? Config::get('laravel-scenario-logger.dp-pfx') : '';
}
