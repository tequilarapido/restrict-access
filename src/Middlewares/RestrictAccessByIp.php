<?php

namespace Tequilarapido\RestrictAccess\Middlewares;

use Closure;
use Tequilarapido\RestrictAccess\Restricter\IpRestricter;

class RestrictAccessByIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = (new IpRestricter($request))->restrict();

        return $response === false ? $next($request) : $response;
    }
}
