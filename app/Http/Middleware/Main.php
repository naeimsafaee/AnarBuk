<?php

namespace App\Http\Middleware;

use Closure;

class Main
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->name=='naeim') return response('not acceptable',401);
        return $next($request);
    }
}
