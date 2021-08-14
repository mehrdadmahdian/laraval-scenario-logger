<?php

namespace Escherchia\LaravelScenarioLogger\Middleware;

use App\Models\User;
use Closure;
use Escherchia\LaravelScenarioLogger\LSL;
use http\Client\Response;
use Illuminate\Support\Facades\Auth;

class LSLMiddleware
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
        User::create([
            'name' => 'sdsdadfadfv',
            'email' => 'sdsdadfadfv',
            'password' => 'sdsdadfadfv',
        ]);
        $response = $next($request);
//        if ($response instanceof Response) {
//            LSL::addResponse($response);
//        }
//        LSL::finish();

        return $response;
    }
}
