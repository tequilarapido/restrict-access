<?php

namespace Tequilarapido\RestrictAccess\Middlewares;

use Closure;
use Tequilarapido\RestrictAccess\Restricter\BasicAuthRestricter;

class RestrictAccessByBasicAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = (new BasicAuthRestricter($request))->restrict();

        return $response === false ? $next($request) : $response;
    }
}
