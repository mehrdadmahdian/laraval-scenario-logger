<?php

namespace Escherchia\LaravelScenarioLogger\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Escherchia\LaravelScenarioLogger\Logger\ScenarioLogger;

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
            ScenarioLogger::logForService('log_request', $request);
            $response = $next($request);
            ScenarioLogger::logForService('log_user', Auth::user());
            ScenarioLogger::logForService('log_response', $response);
            ScenarioLogger::finish();

            return $response;

        } else {
            return $next($request);
        }
    }
}
