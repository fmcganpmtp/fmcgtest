<?php

namespace App\Http\Middleware;

use Closure;

class ConnectRoute
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
        $requestKey = request()->header('Authorization');

        $requestKey = str_replace('Bearer ','', $requestKey);

        $apiKey = config('app.connect.api_key', '');

        if($apiKey == ''){
            abort(403);
        }else{
            if($apiKey !=  $requestKey){
                abort(403);
            }
        }

        return $next($request);
    }
}
