<?php

namespace App\Http\Middleware;

use Closure;

class PermissionRoute
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

        if (!hasPermission($request->route()->getName())) {
            abort(403);
        }

        return $next($request);
    }
}
