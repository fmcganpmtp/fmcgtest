<?php

namespace App\Http\Middleware;

use Closure;

class AdminRoute
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
        $authUser = authUser();
 
        if ($authUser && $authUser->role->type != 'private') {
            abort(403);
        }

        return $next($request);
    }
}
