<?php

namespace Escherchia\LaravelScenarioLogger\Middleware;

use App\Models\User;
use Closure;
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
//        LSL::start();
//        LSL::addRequest($request);
//        if (Auth::user())
//            LSL::addUser(Auth::user());
        $user = User::create([
            'name' => 'sdsdadfadfv',
            'email' => rand(),
            'password' => 'sdsdadfadfv',
        ]);
        User::find($user->id)->update([
            'name' => 'sdsdadfadfv',
            'email' => rand(),
            'password' => 'sdsdadfadfv',
        ]);
        $user->delete();
        $response = $next($request);
//        if ($response instanceof Response) {
//            LSL::addResponse($response);
//        }
//        LSL::finish();
        dd(ScenarioLogger::report());
        return $response;
    }
}
