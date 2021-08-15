<?php

namespace Escherchia\LaravelScenarioLogger\Middleware;

use App\Models\User;
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
        if (lsl_service_is_active('log-request'))
            ScenarioLogger::logForService('log-request', $request);

        if (Auth::user())
            ScenarioLogger::setUser(Auth::user());


        $user = User::create(['name' => 'sdsdadfadfv', 'email' => rand(), 'password' => 'sdsdadfadfv']);
        User::find($user->id)->update(['name' => 'sdsdadfadfv', 'email' => rand(), 'password' => 'sdsdadfadfv']);
        $user->delete();

        $response = $next($request);

        ScenarioLogger::finish();

        return $response;
    }
}
