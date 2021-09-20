<?php

namespace Escherchia\LaravelScenarioLogger\Middleware;

use Closure;
use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;
use Illuminate\Support\Facades\Auth;

class LaravelScenarioLoggerMiddleware
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (lsl_is_active()) {
            ScenarioLogger::start();
            lsl_service_is_active('log_request') ? ScenarioLogger::logForService('log_request', $request) : null;
            Auth::check() ? ScenarioLogger::setUser(Auth::user()) : null;
            $response = $next($request);
            lsl_service_is_active('log_response') ? ScenarioLogger::logForService('log_response', $response) : null;
            ScenarioLogger::finish();

            return $response;
        } else {
            return $next($request);
        }
    }
}
